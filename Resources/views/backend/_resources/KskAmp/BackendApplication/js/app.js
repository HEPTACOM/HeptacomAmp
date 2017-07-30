import Vue from 'vue';
import VueRouter from 'vue-router';
import Application from './Application.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: []
});
new Vue({
    router,
    render: h => h(Application)
}).$mount('#ksk_amp_backend_application');
