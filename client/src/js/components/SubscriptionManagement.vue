<template>
    <div>
        <h3>Manage Your Subscription</h3>

        <label>Card Holder Name</label>
        <input id="card-holder-name" type="text" v-model="name" class="form-control mb-2">

        <label>Card</label>
        <div id="card-element">

        </div>

        <button class="btn btn-primary mt-3" id="add-card-button" v-on:click="submitPaymentMethod()">
            Save Payment Method
        </button>

        <div class="mt-3 mb-3">
            OR
        </div>

        <div v-show="paymentMethodsLoadStatus == 2 
            && paymentMethods.length == 0"
            class="">
                No payment method on file, please add a payment method.
        </div>

        <div v-show="paymentMethodsLoadStatus == 2 
                && paymentMethods.length > 0">
            <div v-for="(method, key) in paymentMethods" 
                    v-bind:key="'method-'+key" 
                    v-on:click="paymentMethodSelected = method.id"
                    class="border rounded row p-1"
                    v-bind:class="{
                    'bg-success text-light': paymentMethodSelected == method.id    
                }">
                    <div class="col-2">
                        {{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }}
                    </div>
                    <div class="col-7">
                        Ending In: {{ method.last_four }} Exp: {{ method.exp_month }} / {{ method.exp_year }}
                    </div>
                    <div class="col-3">
                        <span v-on:click.stop="removePaymentMethod( method.id )">Remove</span>
                    </div>
            </div>
        </div>

        <h4 class="mt-3 mb-3">Select Subscription</h4>

        <div class="mt-3 row rounded border p-1" 
             v-bind:class="{'bg-success text-light': selectedPlan == 'price_1H4MLzGPqFnokzh8s7GL2RUV'}" 
             v-on:click="selectedPlan = 'price_1H4MLzGPqFnokzh8s7GL2RUV'">
            <div class="col-6">
                Basic
            </div>
            <div class="col-6">
                $1/mo.
            </div>
        </div>

        <div class="mt-3 row rounded border p-1" 
             v-bind:class="{'bg-success text-light': selectedPlan == 'price_1H4MLzGPqFnokzh84nneuFUm'}" 
             v-on:click="selectedPlan = 'price_1H4MLzGPqFnokzh84nneuFUm'">
            <div class="col-6">
                Professional
            </div>
            <div class="col-6">
                $2.5/mo.
            </div>
        </div>

        <div class="mt-3 row rounded border p-1" 
             v-bind:class="{'bg-success text-light': selectedPlan == 'price_1H4MLzGPqFnokzh86c0FSfeB'}" 
             v-on:click="selectedPlan = 'price_1H4MLzGPqFnokzh86c0FSfeB'">
            <div class="col-6">
                Enterprise
            </div>
            <div class="col-6">
                $5/mo.
            </div>
        </div>

        <button class="btn btn-primary mt-3" id="add-card-button" v-on:click="updateSubscription()">
            Subscribe
        </button>
    </div>
</template>
<script>

export default {
    name: 'SubScription',

    data(){
        return {
            stripeAPIToken: 'pk_test_5l3xlABNOIznzGHPoxfJLIKk00b1VLg1fz',

            stripe: '',
            elements: '',
            card: '',

            intentToken: '',

            name: '',
            addPaymentStatus: 0,
            addPaymentStatusError: '',

            paymentMethods: [],
            paymentMethodsLoadStatus: 0,
            paymentMethodSelected: {},

            selectedPlan: '',
        }
    },

    mounted(){
        this.includeStripe('js.stripe.com/v3/', function(){
            this.configureStripe();
        }.bind(this) );

        this.loadIntent();

        this.loadPaymentMethods();
    },

    methods: {
        /*
            Includes Stripe.js dynamically
        */
        includeStripe( URL, callback ){
            var documentTag = document, tag = 'script',
                object = documentTag.createElement(tag),
                scriptTag = documentTag.getElementsByTagName(tag)[0];
            object.src = '//' + URL;
            if (callback) { object.addEventListener('load', function (e) { callback(null, e); }, false); }
            scriptTag.parentNode.insertBefore(object, scriptTag);
        },

        /*
            Configures Stripe by setting up the elements and 
            creating the card element.
        */
        configureStripe(){
            this.stripe = Stripe( this.stripeAPIToken );

            this.elements = this.stripe.elements();
            this.card = this.elements.create('card');

            this.card.mount('#card-element');
        },

        /*
            Loads the payment intent key for the user to pay.
        */
        loadIntent(){
            axios.get('/api/stripe/user/setup-intent')
                .then( function( response ){
                    this.intentToken = response.data;
                }.bind(this));
        },

        /*
            Uses the intent to submit a payment method
            to Stripe. Upon success, we save the payment
            method to our system to be used.
        */
        submitPaymentMethod(){
            this.addPaymentStatus = 1;

            this.stripe.confirmCardSetup(
                this.intentToken.client_secret, {
                    payment_method: {
                        card: this.card,
                        billing_details: {
                            name: this.name
                        }
                    }
                }
            ).then(function(result) {
                if (result.error) {
                    this.addPaymentStatus = 3;
                    this.addPaymentStatusError = result.error.message;
                } else {
                    this.savePaymentMethod( result.setupIntent.payment_method );
                    this.addPaymentStatus = 2;
                    this.card.clear();
                    this.name = '';
                }
            }.bind(this));
        },

        /*
            Saves the payment method for the user and
            re-loads the payment methods.
        */
        savePaymentMethod( method ){
            axios.post('/api/stripe/user/payments', {
                payment_method: method
            }).then( function(){
                this.loadPaymentMethods();
            }.bind(this));
        },

        /*
            Loads all of the payment methods for the
            user.
        */
        loadPaymentMethods(){
            this.paymentMethodsLoadStatus = 1;

            axios.get('/api/stripe/user/payment-methods')
                .then( function( response ){
                    this.paymentMethods = response.data;

                    this.paymentMethodsLoadStatus = 2;
                    // this.setDefaultPaymentMethod();
                }.bind(this));
        },

        removePaymentMethod( paymentID ){
            axios.post('/api/stripe/user/remove-payment', {
                id: paymentID
            }).then( function( response ){
                this.loadPaymentMethods();
            }.bind(this));
        },

        updateSubscription(){
            axios.put('/api/stripe/user/subscription', {
                plan: this.selectedPlan,
                payment: this.paymentMethodSelected
            }).then( function( response ){
                console.log( response );
            }.bind(this));
        },
    }
}
</script>
<style lang="scss">
</style>
