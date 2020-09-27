const AddrShow = () => import('../../pages/addrs/Show.vue');

export default {
    name: 'addrs.show',
    path: ':addr',
    component: AddrShow,
    meta: {
        breadcrumb: 'show',
        title: 'Show Addr',
    },
};
