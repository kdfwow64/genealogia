const MediaObjectShow = () => import('../../pages/mediaobjects/Show.vue');

export default {
    name: 'mediaobjects.show',
    path: ':mediaobjects',
    component: MediaObjectShow,
    meta: {
        breadcrumb: 'show',
        title: 'Show Media Object',
    },
};
