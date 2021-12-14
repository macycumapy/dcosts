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
    return dispatch('request/get', {
      url: `cash-flow?page=${page}`,
    }, { root: true }).then((data) => {
      commit('setCashFlows', data.data);
    });
  },
};

const mutations = {
  setCashFlows: (state, payload) => {
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
