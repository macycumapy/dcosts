const state = {
    costItems: [],
};

const getters = {
    costItems: state => state.costItems,
};

const actions = {
    getCostItems: ({ commit, dispatch }) => {
        dispatch('request/get', {
            url: 'cost-items',
        }).then((data) => {
            commit('setCostItems', data.data);
        });
    },
    addCostItem: ({ dispatch }, payload) => {
        dispatch('request/post', {
            url: 'cost-items',
            params: payload,
        }).then(() => {
            dispatch('getCostItems');
        });
    },
    updateCostItem: ({ dispatch }, payload) => {
        dispatch('request/put', {
            url: `cost-items/${payload.id}`,
            params: payload,
        }).then(() => {
            dispatch('getCostItems');
        });
    },
    deleteCostItem: ({ dispatch }, id) => {
        dispatch('request/del', {
            url: `cost-items/${id}`,
        }).then(() => {
            dispatch('getCostItems');
        });
    },
};

const mutations = {
    setCostItems: (state, payload) => {
        state.costItems = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
