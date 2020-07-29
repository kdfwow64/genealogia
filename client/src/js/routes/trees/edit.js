const TreeEdit = () => import('../../pages/trees/Edit.vue');

export default {
    name: 'trees.edit',
    path: ':tree/edit',
    component: TreeEdit,
    meta: {
        breadcrumb: 'edit',
        title: 'Edit Tree',
    },
};
