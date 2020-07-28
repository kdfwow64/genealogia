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
                    <button v-if="has_payment_method"
                        @click="subscribe()"
                        class="card-footer-item">
                        Subscribe
                    </button>
                    <router-link v-else
                        :to="{ name: 'payment.index', params: { planId: plan.plan_id }}"
                        class="card-footer-item">
                        Subscribe
                    </router-link>
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
                { id: 1, title: '1GBP for 1 tree monthly', plan_id: 'price_1H9ZbJJZEMHu7eXxlVHmrPiN' },
                { id: 3, title: '2.50GBP for 10 trees monthly', plan_id: 'price_1H9ZbJJZEMHu7eXxTVw8KMqw' },
                { id: 5, title: '5GBP for unlimited trees monthly', plan_id: 'price_1H9ZbJJZEMHu7eXxKtlWHRjL' },
                { id: 2, title: '10GBP for 1 tree yearly', plan_id: 'price_1H9ZbKJZEMHu7eXxFUsuK0kd' },
                { id: 4, title: '25GBP for 10 trees yearly', plan_id: 'price_1H9ZbKJZEMHu7eXxf2jzzyol' },
                { id: 6, title: '50GBP for unlimited trees yearly', plan_id: 'price_1H9ZbJJZEMHu7eXxIv0Kn3NG' },
            ],
        };
    },
    created() {
        axios.get('/api/has-payment-method')
            .then(response => {
                this.has_payment_method = response.data.success;
            });
    },
    methods: {
        subscribe() {
            console.log('subscribe!');
        },
    },
};

</script>
