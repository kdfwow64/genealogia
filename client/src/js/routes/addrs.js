import routeImporter from '@core/modules/importers/routeImporter';

const routes = routeImporter(require.context('./addrs', false, /.*\.js$/));
const RouterView = () => import('@core/bulma/pages/Router.vue');

export default {
    path: '/addrs',
    component: RouterView,
    meta: {
        breadcrumb: 'addrs',
        route: 'addrs.index',
    },
    children: routes,
};
