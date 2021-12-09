const state = {
  list: [],
  pages: 1,
  page: 1,
};

const getters = {
  list: state => state.list,
  pages: state => state.pages,
  page: state => state.page,
};

const actions = {
  getList: ({ commit, dispatch, state }, page = state.page) => {
    dispatch('request/get', {
      url: `cash-outflow?page=${page}`,
    }, { root: true }).then((data) => {
      commit('setCashOutflows', data.data);
    });
  },
  get: ({ dispatch }, id) => dispatch('request/get', {
      url: `cash-outflow/${id}`,
    }, { root: true }),
  create: ({ dispatch }, payload) => dispatch('request/post', {
      url: 'cash-outflow',
      params: payload,
    }, { root: true }),
  update: ({ dispatch }, payload) => dispatch('request/put', {
      url: `cash-outflow/${payload.id}`,
      params: payload,
    }, { root: true }),
  delete: ({ dispatch }, id) => dispatch('request/del', {
      url: `cash-outflow/${id}`,
    }, { root: true }).then(() => {
      dispatch('getList');
    }),
};

const mutations = {
  setCashOutflows: (state, payload) => {
    state.list = payload.data;
    state.pages = payload.pages;
    state.page = payload.page;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true,
};
