const CancelIndex = () => import('../pages/subscription/Cancel.vue');

export default {
    name: 'subscription.cancel',
    path: '/cancel',
    component: CancelIndex,
    meta: {
        breadcrumb: 'cancel',
        title: 'Cancel',
    },
};
