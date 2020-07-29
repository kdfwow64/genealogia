const MediaObjectCreate = () => import('../../pages/mediaobjects/Create.vue');

export default {
    name: 'mediaobjects.create',
    path: 'create',
    component: MediaObjectCreate,
    meta: {
        breadcrumb: 'create',
        title: 'Create Media Object',
    },
};
