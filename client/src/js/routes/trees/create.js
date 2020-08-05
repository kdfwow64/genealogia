const TreeCreate = () => import('../../pages/trees/Create.vue');

export default {
    name: 'trees.create',
    path: 'create',
    component: TreeCreate,
    meta: {
        breadcrumb: 'create',
        title: 'Create Tree',
    },
};
