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
      url: `cash-inflow?page=${page}`,
    }, { root: true }).then((data) => {
      commit('setCashInflows', data.data);
    });
  },
  create: ({ dispatch }, payload) => {
    dispatch('request/post', {
      url: 'cash-inflow',
      params: payload,
    }, { root: true }).then(() => {
      dispatch('getList');
    });
  },
  update: ({ dispatch }, payload) => {
    dispatch('request/put', {
      url: `cash-inflow/${payload.id}`,
      params: payload,
    }, { root: true }).then(() => {
      dispatch('getList');
    });
  },
  delete: ({ dispatch }, id) => {
    dispatch('request/del', {
      url: `cash-inflow/${id}`,
    }, { root: true }).then(() => {
      dispatch('getList');
    });
  },
};

const mutations = {
  setCashInflows: (state, payload) => {
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
