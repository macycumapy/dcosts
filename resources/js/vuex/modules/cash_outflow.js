const state = {
  cashOutflows: [],
};

const getters = {
  cashOutflows: state => state.cashOutflows,
};

const actions = {
  getCashOutflows: ({ commit, dispatch }) => {
    dispatch('request/get', {
      url: 'cash-outflow',
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
    state.cashOutflows = payload;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
