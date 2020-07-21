import routeImporter from '@core/modules/importers/routeImporter';

const routes = routeImporter(require.context('./privacy', false, /.*\.js$/));
const RouterView = () => import('@core/bulma/pages/Router.vue');

export default {
    path: '/privacy',
    component: RouterView,
    meta: {
        breadcrumb: 'privacy',
        route: 'privacy.index',
    },
    children: routes,
};
