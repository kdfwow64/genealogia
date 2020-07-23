const SubscriptionSuccess = () => import('../pages/subscription/Success.vue');

export default {
    name: 'subscription.success',
    path: '/success',
    component: SubscriptionSuccess,
    meta: {
        breadcrumb: 'success',
        title: 'Success',
    },
};
