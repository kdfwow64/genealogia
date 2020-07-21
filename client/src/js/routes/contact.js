import routeImporter from '@core/modules/importers/routeImporter';

const routes = routeImporter(require.context('./contact', false, /.*\.js$/));
const RouterView = () => import('@core/bulma/pages/Router.vue');

export default {
    path: '/contact',
    component: RouterView,
    meta: {
        breadcrumb: 'contact',
        route: 'contact.index',
	guestGuard: true,
    },
    children: routes,
};
