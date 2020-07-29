<template>
    <div class="columns is-multiline">
        <div class="column">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <input
                            v-model="cardHolderName"
                            class="input is-small"
                            id="card-holder-name"
                            placeholder="Enter card holder name"
                            type="text">

                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element"/>
</div>

                    <footer class="card-footer">
                        <button
                            @click="confirmCard()"
                            data-secret="{{ clientSecret }}"
                            class="card-footer-item">
                            Pay
                        </button>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';

export default {
    name: 'Index',
    data() {
        return {
            stripe: null,
            cardElement: null,
            cardHolderName: null,
            clientSecret: null,
            plan_id: null,
            intent: null,
            payment_method: null,
        };
    },
    async created() {
        this.plan_id = this.$route.params;
        axios.get('/api/get-intent')
            .then(response => {
                this.clientSecret = response.data.intent.client_secret;
            });
        this.stripe = await loadStripe('pk_test_51H7yygJZEMHu7eXxCr3ZJfotMBatunOIqfyZOKUPo3An1z2JF5YH8YhsxmCufKtb2PxxPiXah7xGmIxUXskTvDWp00fEsEHvSS');
        const elements = this.stripe.elements();
        this.cardElement = elements.create('card');
        this.cardElement.mount('#card-element');
    },
    methods: {
        async confirmCard() {
            const { setupIntent, error } = await this.stripe.confirmCardSetup(
                this.clientSecret, {
                    payment_method: {
                        card: this.cardElement,
                        billing_details: { name: this.cardHolderName },
                    },
                },
            );
            if (error) {
                // Display "error.message" to the user...
                console.log(error.message);
            } else {
                // The card has been verified successfully...
                this.payment_method = setupIntent.payment_method;
                this.subscribe();
            }
        },
        subscribe() {
            axios.post('/api/subscribe', {
                payment_method: this.payment_method,
                plan_id: this.plan_id,
                card_holder_name: this.cardHolderName,
            })
                .then(response => {
                    if (response.data.success) {
                        this.$router.push({ name: 'subscription.success' });
                    }
                });
        },
    },
};

</script>
