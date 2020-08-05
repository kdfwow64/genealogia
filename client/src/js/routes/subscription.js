const SubscriptionIndex = () => import('../pages/subscription/Index.vue');

export default {
    name: 'subscription.index',
    path: '/subscription',
    component: SubscriptionIndex,
    meta: {
        breadcrumb: 'subscription',
        title: 'Subscription',
    },
};
