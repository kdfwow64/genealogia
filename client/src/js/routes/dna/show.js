const DnaShow = () => import('../../pages/dna/Show.vue');

export default {
    name: 'dna.show',
    path: ':dna',
    component: DnaShow,
    meta: {
        breadcrumb: 'show',
        title: 'Show Dna',
    },
};
