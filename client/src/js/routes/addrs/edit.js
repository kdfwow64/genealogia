const AddrEdit = () => import('../../pages/addrs/Edit.vue');

export default {
    name: 'addrs.edit',
    path: ':addr/edit',
    component: AddrEdit,
    meta: {
        breadcrumb: 'edit',
        title: 'Edit Addr',
    },
};
