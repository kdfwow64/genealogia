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
                    <div
                        class="card-footer-item"
                        v-if="has_payment_method && plan.subscribed == false">
                        <button @click="open(plan.id)"
                            class="button">
                            Subscribe
                        </button>
                    </div>
                    <div class="card-footer-item" v-if="has_payment_method == false">
                        <router-link tag="button"
                            :to="{ name: 'payment.index', params: { planId: plan.id }}"
                            class="button">
                            Subscribe
                        </router-link>
                    </div>
                    <div class="card-footer-item" v-if="plan.subscribed">
                        <button
                            @click="open(null)"
                            class="button" :class="{ 'is-success': plan.subscribed }">
                            Unsubscribe
                        </button>
                    </div>
                </footer>
            </div>
        </div>
        <modal-card v-if="isActive" @close="close()">
            <template v-slot:header>
                Confirmation
            </template>
            <template v-slot:body>
                Are you sure?
            </template>
            <template v-slot:footer>
                <button
                    class="button is-success"
                    @click="subscribe()"
                    v-if="selectedPlanId != null">
Yes
</button>
                <button class="button is-success" @click="unsubscribe()" v-else>
Yes
</button>
                <button @click="close()" class="button">
No
</button>
            </template>
        </modal-card>
    </div>
</template>

<script>
import { ModalCard } from '@enso-ui/modal/bulma';

export default {
    name: 'Index',
    components: {
        ModalCard,
    },
    data() {
        return {
            has_payment_method: false,
            plans: [],
            selectedPlanId: null,
            isActive: false,
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
                        this.plans
                            .find(plan => plan.id !== response.data.plan_id)
                            .subscribed = false;
                    }
                });
        },
        subscribe() {
            axios.post('/api/subscribe', {
                plan_id: this.selectedPlanId,
            })
                .then(response => {
                    if (response.data.success) {
                        this.isActive = false;
                        this.$toastr.success('Subscribe Successfully!');
                        this.getCurrentSubscription();
                    }
                });
        },
        unsubscribe() {
            axios.post('/api/unsubscribe')
                .then(response => {
                    if (response.data.success) {
                        this.isActive = false;
                        this.$toastr.success('Unsubscribed Successfully!');
                        this.getCurrentSubscription();
                    }
                });
        },
        open(planId) {
            this.isActive = true;
            this.selectedPlanId = planId;
        },
        close() {
            this.isActive = false;
        },
    },
};

</script>
