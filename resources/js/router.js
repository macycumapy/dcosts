import Router from 'vue-router';
import { store } from './vuex/store';
import Login from './components/Auth/Login.vue';
import Register from './components/Auth/Register.vue';
import Home from './components/Cabinet/Home.vue';
import NomenclatureTypeList from './components/Cabinet/NomenclatureTypeList.vue';
import NomenclatureList from './components/Cabinet/NomenclatureList.vue';
import PartnerList from './components/Cabinet/PartnerList.vue';
import CostItemList from './components/Cabinet/CostItemList.vue';
import CashInflowList from './components/Cabinet/CashInflowList.vue';
import CashOutflowList from './components/Cabinet/CashOutflowList.vue';

const onlyAuthenticated = (to, from, next) => {
    if (store.getters.isAuthenticated) {
        next();
        return;
    }
    next('/login');
};

const onlyNotAuthenticated = (to, from, next) => {
    if (!store.getters.isAuthenticated) {
        next();
        return;
    }
    next('/');
};

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
            path: '/nomenclature-type',
            name: 'nomenclatureType',
            component: NomenclatureTypeList,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/nomenclature',
            name: 'nomenclature',
            component: NomenclatureList,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/partners',
            name: 'partners',
            component: PartnerList,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/cost-items',
            name: 'costItems',
            component: CostItemList,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/cash-inflows',
            name: 'cashInflows',
            component: CashInflowList,
            beforeEnter: onlyAuthenticated,
        },
        {
            path: '/cash-outflows',
            name: 'cashOutflows',
            component: CashOutflowList,
            beforeEnter: onlyAuthenticated,
        },
    ],
});
