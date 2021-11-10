import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import preloader from './modules/preloader';
import request from './modules/request';
import nomenclatureType from './modules/nomenclature_type';
import nomenclature from './modules/nomenclature';
import partner from './modules/partner';
import costItem from './modules/cost_item';
import cashInflows from './modules/cash_inflow';
import cashOutflows from './modules/cash_outflow';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        auth,
        preloader,
        request,
        nomenclatureType,
        nomenclature,
        partner,
        costItem,
        cashInflows,
        cashOutflows,
    },
});
