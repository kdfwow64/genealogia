const MediaObjectEdit = () => import('../../pages/mediaobjects/Edit.vue');

export default {
    name: 'mediaobjects.edit',
    path: ':mediaobject/edit',
    component: MediaObjectEdit,
    meta: {
        breadcrumb: 'edit',
        title: 'Edit Media Object',
    },
};
