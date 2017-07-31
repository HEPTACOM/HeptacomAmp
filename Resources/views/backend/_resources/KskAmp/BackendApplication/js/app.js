import Vue from 'vue';
import VueRouter from 'vue-router';
import Application from './Application.vue';
import ViewDashboard from './views/Dashboard.vue';
import ViewCacheWarming from './views/CacheWarming.vue';
import ViewDependencyOverview from './views/DependencyOverview.vue';
import ViewValidation from './views/Validation.vue';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: ViewDashboard
    },
    {
        path: '/cache_warmer',
        component: ViewCacheWarming
    },
    {
        path: '/dependencies',
        component: ViewDependencyOverview
    },
    {
        path: '/validation',
        component: ViewValidation
    }
];

new Vue({
    router: new VueRouter({ routes }),
    render: h => h(Application)
}).$mount('#ksk_amp_backend_application');
