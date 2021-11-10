const state = {
  cashOutflows: [],
  pages: 1,
  page: 1,
};

const getters = {
  cashOutflows: state => state.cashOutflows,
  cashOutflowsPages: state => state.pages,
  cashOutflowsCurrentPage: state => state.page,
};

const actions = {
  getCashOutflows: ({ commit, dispatch }, page = 1) => {
    dispatch('request/get', {
      url: `cash-outflow?page=${page}`,
    }).then((data) => {
      commit('setCashOutflows', data.data);
    });
  },
  addCashOutflow: ({ dispatch }, payload) => {
    dispatch('request/post', {
      url: 'cash-outflow',
      params: payload,
    }).then(() => {
      dispatch('getCashOutflows');
    });
  },
  updateCashOutflow: ({ dispatch }, payload) => {
    dispatch('request/put', {
      url: `cash-outflow/${payload.id}`,
      params: payload,
    }).then(() => {
      dispatch('getCashOutflows');
    });
  },
  deleteCashOutflow: ({ dispatch }, id) => {
    dispatch('request/del', {
      url: `cash-outflow/${id}`,
    }).then(() => {
      dispatch('getCashOutflows');
    });
  },
};

const mutations = {
  setCashOutflows: (state, payload) => {
    state.cashOutflows = payload.data;
    state.pages = payload.pages;
    state.page = payload.page;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
