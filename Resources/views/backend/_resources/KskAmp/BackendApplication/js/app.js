import Vue from 'vue';
import VueRouter from 'vue-router';
import Application from './Application.vue';
import ViewDashboard from './views/Dashboard.vue';
import ViewDependencyOverview from './views/DependencyOverview.vue';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: ViewDashboard
    },
    {
        path: '/dependencies',
        component: ViewDependencyOverview
    }
];

new Vue({
    router: new VueRouter({ routes }),
    render: h => h(Application)
}).$mount('#ksk_amp_backend_application');
