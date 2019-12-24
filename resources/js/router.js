import Vue from 'vue';
import Router from 'vue-router';
import {store} from './vuex/store.js'

const onlyAuthenticated = (to, from, next) => {
    if (store.getters.isAuthenticated) {
        next();
        return
    }
    next('/login')
};

const onlyNotAuthenticated = (to, from, next) => {
    if (!store.getters.isAuthenticated) {
        next();
        return
    }
    next('/')
};

import Home from './components/Home'
import CostItems from './components/Dictionaries/CostItem'
import Nomenclature from './components/Dictionaries/Nomenclature'
import NomenclatureType from './components/Dictionaries/NomenclatureType'
import Partner from './components/Dictionaries/Partner'
import CashFlow from './components/Documents/CashFlow'
import CashInflow from './components/Documents/CashInflow'
import Login from './components/Auth/Login'
import Register from './components/Auth/Register'

Vue.use(Router);

export const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            beforeEnter: onlyNotAuthenticated,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            beforeEnter: onlyNotAuthenticated,
        },
        {
            path: '/cost_items',
            name: 'costItems',
            component: CostItems,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/nomenclature',
            name: 'nomenclature',
            component: Nomenclature,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/nomenclature_type',
            name: 'nomenclatureType',
            component: NomenclatureType,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/cash_flow',
            name: 'cashFlow',
            component: CashFlow,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/cash_inflows',
            name: 'cashInflows',
            component: CashInflow,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/partners',
            name: 'partners',
            component: Partner,
            beforeEnter: onlyAuthenticated,
        },
    ],
});
