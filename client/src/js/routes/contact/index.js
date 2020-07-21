const ContactIndex = () => import('../../pages/contact/Index.vue');

export default {
    name: 'contact.index',
    path: '',
    component: ContactIndex,
    meta: {
        breadcrumb: 'index',
        title: 'Contact Us',
        guestGuard: true,
    },
};
