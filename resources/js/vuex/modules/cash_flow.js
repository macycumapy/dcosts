import {router} from "../../router";

const state = {
    cash_flows: [],
};

const getters = {
    getCashFlows: state => state.cash_flows
};

const actions = {
    getCashFlows: ({commit, dispatch}) => {
        dispatch('getRequest', {
            url: 'cash_flow'
        }).then((resp) => {
            commit('updateCashFlows', resp);
        });
    },
    addCashFlow: ({dispatch},payload) => {
        dispatch('postRequest', {
            url: 'cash_flow',
            params:payload
        }).then(() => {
            if (router.currentRoute.name === 'home') dispatch('getCashTotalList')
            else dispatch('getCashFlows')
        });
    },
    updateCashFlow: ({dispatch},payload) => {
        dispatch('putRequest', {
            url: 'cash_flow/'+payload.id,
            params:payload
        }).then(() => {
            if (router.currentRoute.name === 'home') dispatch('getCashTotalList')
            else dispatch('getCashFlows')
        });
    },
    deleteCashFlow: ({dispatch},id) => {
        dispatch('delRequest', {
            url: 'cash_flow/'+id
        }).then(() => {
            if (router.currentRoute.name === 'home') dispatch('getCashTotalList')
            else dispatch('getCashFlows')
        });
    },
};

const mutations = {
    updateCashFlows: (state, payload) => {
        state.cash_flows = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
}
