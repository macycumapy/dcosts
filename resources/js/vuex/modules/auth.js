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
  register: ({ dispatch, commit }, payload) => {
    dispatch('request/post', {
      url: 'register',
      params: payload,
    })
      .then(({ data }) => {
        commit('setAuth', data);
        router.push('/');
      });
  },
  login: ({ commit, dispatch }, payload) => {
    dispatch('request/post', {
      url: 'login',
      params: payload,
    })
      .then(({ data }) => {
        commit('setAuth', data);
        router.push('/');
      });
  },
  logout: ({ dispatch, commit }) => {
    dispatch('request/post', {
      url: 'logout',
    })
      .then(() => {
        commit('setAuth', {});
        localStorage.removeItem('access_token');
        router.push('/login');
      });
  },
};

const mutations = {
  setAuth: (state, data) => {
    if (data.token) {
      const token = `Bearer ${data.token}`;
      localStorage.setItem('access_token', token);
      axios.defaults.headers.common.Authorization = token;
    }

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
