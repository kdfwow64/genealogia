const AddrCreate = () => import('../../pages/addrs/Create.vue');

export default {
    name: 'addrs.create',
    path: 'create',
    component: AddrCreate,
    meta: {
        breadcrumb: 'create',
        title: 'Create Addr',
    },
};
