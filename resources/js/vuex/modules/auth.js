import { router } from '../../router';

const { localStorage } = window;

const state = {
    token: localStorage.getItem('access_token') || null,
    user: {},
};

const getters = {
    isAuthenticated: state => !!state.token,
    user: state => state.user,
};

const actions = {
    register: ({ dispatch }, payload) => {
        dispatch('preloader/show');
        return axios.post('/api/register', payload)
          .then(() => {
                dispatch('login', payload);
            }).finally(() => {
                dispatch('preloader/hide');
            });
    },
    login: ({ commit, dispatch }, payload) => {
        dispatch('preloader/show');
        return axios.post('/api/login', payload)
          .then(({ data }) => {
                const token = `Bearer ${data.data.token}`;
                localStorage.setItem('access_token', token);
                axios.defaults.headers.common.Authorization = token;
                commit('setAuth', data.data);
                router.push('/');
            })
          .catch((err) => {
                console.log(err);
            }).finally(() => {
                dispatch('preloader/hide');
            });
    },
    logout: ({ commit }) => {
        axios.post('/api/logout')
            .then(() => {
                commit('setAuth', {});
                localStorage.removeItem('access_token');
                router.push('/login');
            });
    },
};

const mutations = {
    setAuth: (state, data) => {
        state.token = data.token;
        state.user = data.user;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
