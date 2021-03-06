import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import auth from './modules/auth'
import request from './modules/request'
import nomenclature from './modules/nomenclature'
import nomenclature_type from './modules/nomenclature_type'
import cost_item from './modules/cost_item'
import cash_flow from './modules/cash_flow'
import partner from './modules/partner'
import cash_inflow from './modules/cash_inflow'
import home from './modules/home'

export const store = new Vuex.Store({
    modules: {
        auth,
        request,
        nomenclature,
        nomenclature_type,
        cost_item,
        cash_flow,
        partner,
        cash_inflow,
        home,
    }
});
