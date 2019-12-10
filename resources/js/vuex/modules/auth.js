import { router } from './../../router'

let localStorage = window.localStorage;

const state = {
    access_token: localStorage.getItem('access_token') || '',
    expires_in: localStorage.getItem('expires_in') || '',
    user: {},
};

const getters = {
    isAuthenticated: state => !!state.access_token,
    access_token: state => state.access_token,
    user: state => state.user,
};

const actions = {
    register: ({commit, dispatch}, payload) => {
        let actionUrl = '/api/register';
        let data = {
            'name': payload.name,
            'email': payload.email,
            'password': payload.password,
        };
        return new Promise((resolve, reject) => {
            axios.post(actionUrl, data)
                .then((resp) => {
                    dispatch('login',data)
                    resolve(resp)
                })
                .catch((err) => {
                    reject(err.response.data.message);
                })
        })
    },
    login: ({commit, dispatch}, payload) => {
        let actionUrl = '/api/login';
        let data = {
            'email': payload.email,
            'password': payload.password,
        };

        return new Promise((resolve, reject) => {
            axios.post(actionUrl, data)
                .then((resp) => {
                    if (resp.data) {
                        dispatch('setHeaders', resp.data);
                        resolve('Bearer ' + resp.data.access_token);
                    }
                })
                .catch((err) => {
                    reject(err.response.data.message);
                })
        })
    },
    logout: ({commit,dispatch}) => {
        axios.post('/api/logout')
            .then(()=>{
                commit('authLogout');
                dispatch('clearStorage');
                router.push('/login')
            });
    },
    setHeaders: ({commit, dispatch}, payload) => {
        let access_token = 'Bearer ' + payload.access_token;
        payload.expires_in = new Date().getTime() + payload.expires_in * 1000;
        localStorage.setItem('access_token', access_token);
        localStorage.setItem('expires_in', payload.expires_in);
        axios.defaults.headers.common['Authorization'] = access_token;
        commit('authSuccess', { access_token: access_token, refresh_token: payload.refresh_token, expires_in: payload.expires_in });
        router.push('/')
    },
    clearStorage() {
        localStorage.removeItem('access_token');
        localStorage.removeItem('expires_in');
    },
};

const mutations = {
    authSuccess: (state, payload) => {
        state.access_token = payload.access_token;
        state.expires_in = payload.expires_in;
        state.user = payload.user;
    },
    authLogout: (state) => {
        state.access_token = '';
        state.expires_in = '';
        state.user = {};
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
