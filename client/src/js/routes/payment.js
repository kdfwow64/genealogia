const PaymentIndex = () => import('../pages/payment/Index.vue');

export default {
    name: 'payment.index',
    path: '/payment',
    component: PaymentIndex,
    meta: {
        breadcrumb: 'payment',
        title: 'Payment',
    },
};
