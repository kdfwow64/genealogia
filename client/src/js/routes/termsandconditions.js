import routeImporter from '@core/modules/importers/routeImporter';

const routes = routeImporter(require.context('./termsandconditions', false, /.*\.js$/));
const RouterView = () => import('@core/bulma/pages/Router.vue');

export default {
    path: '/termsandconditions',
    component: RouterView,
    meta: {
        breadcrumb: 'termsandconditions',
        route: 'termsandconditions.index',
        guestGuard: true,
    },
    children: routes,
};
