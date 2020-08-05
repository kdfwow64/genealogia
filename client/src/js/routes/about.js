import routeImporter from '@core/modules/importers/routeImporter';

const routes = routeImporter(require.context('./about', false, /.*\.js$/));
const RouterView = () => import('@core/bulma/pages/Router.vue');

export default {
    path: '/about',
    component: RouterView,
    meta: {
        breadcrumb: 'about',
        route: 'about.index',
        guestGuard: true,
    },
    children: routes,
};
