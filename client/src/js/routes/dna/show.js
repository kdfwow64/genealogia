const DnaMatchingShow = () => import('../../pages/dna/Show.vue');

export default {
    name: 'dna.show',
    path: ':dnaMatching',
    component: DnaMatchingShow,
    meta: {
        breadcrumb: 'show',
        title: 'Show Dna Matching',
    },
};
