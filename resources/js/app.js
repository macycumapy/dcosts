require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VModal from 'vue-js-modal';
import App from './components/App.vue';
import { router } from './router';
import { store } from './vuex/store';
import VueToastr2 from 'vue-toastr-2';
import 'vue-toastr-2/dist/vue-toastr-2.min.css';
window.toastr = require('toastr');

Vue.use(VueRouter);
Vue.use(VModal, { dynamic: true, injectModalsContainer: true, dialog: true });
Vue.use(VueToastr2);

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});
