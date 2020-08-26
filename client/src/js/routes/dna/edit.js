const DnaEdit = () => import('..\..\pages/dna/Edit.vue');

export default {
    name: 'dna.edit',
    path: ':dna/edit',
    component: DnaEdit,
    meta: {
        breadcrumb: 'edit',
        title: 'Edit Dna',
    },
};
