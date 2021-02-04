const state = {
    balance: 0,
    cashTotalList:[]
};

const getters = {
    getBalance: state => state.balance,
    getCashTotalList: state => state.cashTotalList,
};

const actions = {
    getBalance: ({commit, dispatch}) => {
        dispatch('getRequest', {
            url: 'balance'
        }).then((resp) => {
            commit('updateBalance', resp);
        });
    },
    getCashTotalList: ({commit, dispatch}) => {
        dispatch('getRequest', {
            url: 'cash_list'
        }).then((resp) => {
            commit('updateCashTotalList', resp);
        });
    },
};

const mutations = {
    updateBalance: (state, payload) => {
        state.balance = payload.sum;
    },
    updateCashTotalList: (state, payload) => {
        state.cashTotalList = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
}
