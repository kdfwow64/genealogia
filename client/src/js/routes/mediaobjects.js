import routeImporter from '@core/modules/importers/routeImporter';

const routes = routeImporter(require.context('./mediaobjects', false, /.*\.js$/));
const RouterView = () => import('@core/bulma/pages/Router.vue');

export default {
    path: '/mediaobjects',
    component: RouterView,
    meta: {
        breadcrumb: 'mediaobjects',
        route: 'mediaobjects.index',
    },
    children: routes,
};
