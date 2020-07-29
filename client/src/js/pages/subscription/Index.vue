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
                        @click="subscribe(plan.plan_id)"
                        class="card-footer-item">
                        Subscribe
                    </button>
                    <router-link tag="button" v-if="has_payment_method == false"
                        :to="{ name: 'payment.index', params: { planId: plan.plan_id }}"
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
            plans: [
                {
                    id: 1, title: '1GBP for 1 tree monthly', plan_id: 'price_1H9ZbJJZEMHu7eXxlVHmrPiN', subscribed: false,
                },
                {
                    id: 3, title: '2.50GBP for 10 trees monthly', plan_id: 'price_1H9ZbJJZEMHu7eXxTVw8KMqw', subscribed: false,
                },
                {
                    id: 5, title: '5GBP for unlimited trees monthly', plan_id: 'price_1H9ZbJJZEMHu7eXxKtlWHRjL', subscribed: false,
                },
                {
                    id: 2, title: '10GBP for 1 tree yearly', plan_id: 'price_1H9ZbKJZEMHu7eXxFUsuK0kd', subscribed: false,
                },
                {
                    id: 4, title: '25GBP for 10 trees yearly', plan_id: 'price_1H9ZbKJZEMHu7eXxf2jzzyol', subscribed: false,
                },
                {
                    id: 6, title: '50GBP for unlimited trees yearly', plan_id: 'price_1H9ZbJJZEMHu7eXxIv0Kn3NG', subscribed: false,
                },
            ],
        };
    },
    created() {
        axios.get('/api/get-current-subscription')
            .then(response => {
                this.has_payment_method = response.data.has_payment_method;
                if (response.data.subscribed) {
                    this.plans
                        .find(plan => plan.plan_id === response.data.plan_id)
                        .subscribed = true;
                }
            });
    },
    methods: {
        subscribe(planId) {
            axios.post('/api/subscribe', {
                plan_id: planId,
            })
                .then(response => {
                    if (response.data.success) {
                        this.$router.push({ name: 'subscription.success' });
                    }
                });
        },
        unsubscribe() {
            axios.post('/api/unsubscribe')
                .then(response => {
                    if (response.data.success) {
                        this.$router.push({ name: 'subscription.cancel' });
                    }
                });
        },
    },
};

</script>
