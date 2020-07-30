<template>
    <div class="columns is-multiline">
        <div class="column" v-for="plan in plans" :key="plan.id">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        {{ plan.title }}
                    </div>
                </div>
                <footer class="card-footer">
                    <button v-if="has_payment_method && plan.subscribed == false"
                        @click="subscribe(plan.id)"
                        class="card-footer-item">
                        Subscribe
                    </button>
                    <router-link tag="button" v-if="has_payment_method == false"
                        :to="{ name: 'payment.index', params: { planId: plan.id }}"
                        class="card-footer-item">
                        Subscribe
                    </router-link>
                    <button v-if="plan.subscribed"
                        @click="unsubscribe()"
                        class="card-footer-item">
                        Unsubscribe
                    </button>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Index',
    data() {
        return {
            has_payment_method: false,
            plans: [],
        };
    },
    created() {
        axios.get('/api/get-plans')
            .then(response => {
                this.plans = response.data.data;
                this.getCurrentSubscription();
            });
    },
    methods: {
        getCurrentSubscription() {
            axios.get('/api/get-current-subscription')
                .then(response => {
                    this.has_payment_method = response.data.has_payment_method;
                    if (response.data.subscribed) {
                        this.plans
                            .find(plan => plan.id === response.data.plan_id)
                            .subscribed = true;
                    }
                });
        },
        subscribe(planId) {
            axios.post('/api/subscribe', {
                plan_id: planId,
            })
                .then(response => {
                    if (response.data.success) {
                        this.$toastr.success('Subscribe Successfully!');
                    }
                });
        },
        unsubscribe() {
            axios.post('/api/unsubscribe')
                .then(response => {
                    if (response.data.success) {
                        this.$toastr.success('Unsubscribed  Successfully!');
                    }
                });
        },
    },
};

</script>
