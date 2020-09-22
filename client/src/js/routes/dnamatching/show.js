const DnaMatchingShow = () => import('../../pages/dnamatching/Show.vue');

export default {
    name: 'dnamatching.show',
    path: ':dnaMatching',
    component: DnaMatchingShow,
    meta: {
        breadcrumb: 'show',
        title: 'Show Dna Matching',
    },
};
