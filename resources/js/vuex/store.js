import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import preloader from './modules/preloader';
import request from './modules/request';
import nomenclatureType from './modules/nomenclature_type';
import nomenclature from './modules/nomenclature';
import partner from './modules/partner';
import category from './modules/category';
import cashInflows from './modules/cash_inflow';
import cashOutflows from './modules/cash_outflow';
import cashFlows from './modules/cash_flow';
import header from './modules/header';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        auth,
        preloader,
        request,
        nomenclatureType,
        nomenclature,
        partner,
        category,
        cashInflows,
        cashOutflows,
        cashFlows,
        header,
    },
});
