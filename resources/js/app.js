require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import App from './components/App.vue';
import { router } from './router';
import { store } from './vuex/store';

Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});
