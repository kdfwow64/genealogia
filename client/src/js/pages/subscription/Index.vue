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
                    <button @click="subscribe(plan.plan_id)" class="card-footer-item">
Subscribe
</button>
                </footer>
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
            email: '',
            user_id: '',
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
        axios.get('/api/auth_user')
            .then(response => {
                this.email = response.data.email;
                this.user_id = response.data.user_id;
            });
    },
    methods: {
        async subscribe(priceId) {
            const DOMAIN = window.location.origin;
            const stripe = await loadStripe('pk_test_51H7yygJZEMHu7eXxCr3ZJfotMBatunOIqfyZOKUPo3An1z2JF5YH8YhsxmCufKtb2PxxPiXah7xGmIxUXskTvDWp00fEsEHvSS');
            stripe
                .redirectToCheckout({
                    customerEmail: this.email,
                    lineItems: [{ price: priceId, quantity: 1 }],
                    successUrl: `${DOMAIN}/success?session_id={CHECKOUT_SESSION_ID}`,
                    cancelUrl: `${DOMAIN}/cancel`,
                    mode: 'subscription',
                    clientReferenceId: `${this.user_id},${priceId}`,
                })
                .then(this.handleResult);
        },
        handleResult(result) {
            if (result.error) {
                const displayError = document.getElementById('error-message');
                displayError.textContent = result.error.message;
            }
        },
    },
};

</script>
