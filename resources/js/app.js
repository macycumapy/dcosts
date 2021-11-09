require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VModal from 'vue-js-modal';
import App from './components/App.vue';
import { router } from './router';
import { store } from './vuex/store';

Vue.use(VueRouter);
Vue.use(VModal, { dynamic: true, injectModalsContainer: true, dialog: true });

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});
