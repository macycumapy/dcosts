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
        const actionUrl = '/api/register';
        const data = {
            name: payload.name,
            email: payload.email,
            password: payload.password,
        };
        return new Promise((resolve, reject) => {
            axios.post(actionUrl, data)
                .then((resp) => {
                    dispatch('login', data);
                    resolve(resp);
                })
                .catch((err) => {
                    reject(err.response.data.message);
                });
        });
    },
    login: ({ commit }, payload) => {
        const actionUrl = '/api/login';
        const data = {
            email: payload.email,
            password: payload.password,
        };

        return axios.post(actionUrl, data)
          .then(({ data }) => {
                const token = `Bearer ${data.data.token}`;
                localStorage.setItem('access_token', token);
                axios.defaults.headers.common.Authorization = token;
                commit('setAuth', data.data);
                router.push('/');
            })
          .catch((err) => {
                console.log(err);
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
