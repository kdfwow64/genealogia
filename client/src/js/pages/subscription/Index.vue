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
            plans: [
                { id: 1, title: '1GBP for 1 tree monthly or 10GBP a year', plan_id: 'price_1H7z4qJZEMHu7eXxnASNyYvN' },
                { id: 2, title: '2.50GBP for 10 trees monthly or 25 yearly', plan_id: 'price_1H7z2uJZEMHu7eXx2CprHmpI' },
                { id: 3, title: '5GBP for unlimited trees monthly or 50GBP a year', plan_id: 'price_1H7z2uJZEMHu7eXx2CprHmpI' },
            ],
        };
    },
    methods: {
        async subscribe(priceId) {
            const DOMAIN = window.location.origin;
            const stripe = await loadStripe('pk_test_51H7yygJZEMHu7eXxCr3ZJfotMBatunOIqfyZOKUPo3An1z2JF5YH8YhsxmCufKtb2PxxPiXah7xGmIxUXskTvDWp00fEsEHvSS');
            stripe
                .redirectToCheckout({
                    lineItems: [{ price: priceId, quantity: 1 }],
                    successUrl:
                `${DOMAIN}/success?session_id={CHECKOUT_SESSION_ID}`,
                    cancelUrl: `${DOMAIN}/cancel`,
                    mode: 'subscription',
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
