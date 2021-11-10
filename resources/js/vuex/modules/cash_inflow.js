const state = {
    cashInflows: [],
};

const getters = {
    cashInflows: state => state.cashInflows,
};

const actions = {
    getCashInflows: ({ commit, dispatch }) => {
        dispatch('request/get', {
            url: 'cash-inflow',
        }).then((data) => {
            commit('setCashInflows', data.data);
        });
    },
    addCashInflow: ({ dispatch }, payload) => {
        dispatch('request/post', {
            url: 'cash-inflow',
            params: payload,
        }).then(() => {
            dispatch('getCashInflows');
        });
    },
    updateCashInflow: ({ dispatch }, payload) => {
        dispatch('request/put', {
            url: `cash-inflow/${payload.id}`,
            params: payload,
        }).then(() => {
            dispatch('getCashInflows');
        });
    },
    deleteCashInflow: ({ dispatch }, id) => {
        dispatch('request/del', {
            url: `cash-inflow/${id}`,
        }).then(() => {
            dispatch('getCashInflows');
        });
    },
};

const mutations = {
    setCashInflows: (state, payload) => {
        state.cashInflows = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
