import routeImporter from '@core/modules/importers/routeImporter';

const routes = routeImporter(require.context('./dna', false, /.*\.js$/));
const RouterView = () => import('@core/bulma/pages/Router.vue');

export default {
    path: '\dna',
    component: RouterView,
    meta: {
        breadcrumb: 'dna',
        route: 'dna.index',
    },
    children: routes,
};
