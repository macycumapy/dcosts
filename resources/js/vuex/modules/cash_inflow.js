const state = {
    cash_inflows: [],
};

const getters = {
    getCashInflows: state => state.cash_inflows
};

const actions = {
    getCashInflows: ({commit, dispatch}) => {
        dispatch('getRequest', {
            url: 'cash_inflow'
        }).then((resp) => {
            commit('updateCashInflows', resp);
        });
    },
    addCashInflow: ({dispatch},payload) => {
        dispatch('postRequest', {
            url: 'cash_inflow',
            params:payload
        }).then(() => {
            dispatch('getCashInflows')
        });
    },
    updateCashInflow: ({dispatch},payload) => {
        dispatch('putRequest', {
            url: 'cash_inflow/'+payload.id,
            params:payload
        }).then(() => {
            dispatch('getCashInflows')
        });
    },
    deleteCashInflow: ({dispatch},id) => {
        dispatch('delRequest', {
            url: 'cash_inflow/'+id
        }).then(() => {
            dispatch('getCashInflows')
        });
    },
};

const mutations = {
    updateCashInflows: (state, payload) => {
        state.cash_inflows = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
}
