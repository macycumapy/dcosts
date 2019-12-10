import Vue from 'vue';
import Router from 'vue-router';
import {store} from './vuex/store.js'

import Home from './components/Home'
import Users from './components/Users'
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
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
        {
            path: '/cost_items',
            name: 'users',
            component: Users,
        },
    ],
});

router.beforeEach((to, from, next) => {
    if (store.getters.isAuthenticated) {
        if (to.name === 'login' || to.name === 'register') next({name: 'home'});
        else next()
    } else {
        if (to.name === 'login' || to.name === 'register') next();
        else next({name: 'login'})
    }
});
