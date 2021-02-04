const state = {
    cost_items: [],
};

const getters = {
    getCostItems: state => state.cost_items
};

const actions = {
    getCostItems: ({commit, dispatch}) => {
        dispatch('getRequest', {
            url: 'cost_item'
        }).then((resp) => {
            commit('updateCostItems', resp);
        });
    },
    addCostItem: ({dispatch},payload) => {
        dispatch('postRequest', {
            url: 'cost_item',
            params:payload
        }).then(() => {
            dispatch('getCostItems')
        });
    },
    updateCostItem: ({dispatch},payload) => {
        dispatch('putRequest', {
            url: 'cost_item/'+payload.id,
            params:payload
        }).then(() => {
            dispatch('getCostItems')
        });
    },
    deleteCostItem: ({dispatch},id) => {
        dispatch('delRequest', {
            url: 'cost_item/'+id
        }).then(() => {
            dispatch('getCostItems')
        });
    },
};

const mutations = {
    updateCostItems: (state, payload) => {
        state.cost_items = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
}
