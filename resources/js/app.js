/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import VModal from 'vue-js-modal'

Vue.use(VueRouter);
Vue.use(VModal,{ dynamic: true, injectModalsContainer: true , dialog:true});

import App from './components/App'
import SelectList from "./components/Additional/SelectList";
import NomenclatureModal from "./components/Dictionaries/Modals/Nomenclature";
import { store } from './vuex/store.js'
import { router } from './router.js'

Vue.component('SelectList',SelectList)
Vue.component('NomenclatureModal',NomenclatureModal)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {App},
    router,
    store
});
