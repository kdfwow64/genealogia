import routeImporter from '@core/modules/importers/routeImporter';

const routes = routeImporter(require.context('./dnamatching', false, /.*\.js$/));
const RouterView = () => import('@core/bulma/pages/Router.vue');

export default {
    path: '/dnamatching',
    component: RouterView,
    meta: {
        breadcrumb: 'dnamatching',
        route: 'dnamatching.index',
    },
    children: routes,
};
