const state = {
    categories: [],
};

const getters = {
    categories: state => state.categories,
};

const actions = {
    getCategories: ({ commit, dispatch }) => {
        dispatch('request/get', {
            url: 'categories',
        }).then((data) => {
            commit('setCategories', data.data);
        });
    },
    addCategory: ({ dispatch }, payload) => dispatch('request/post', {
            url: 'categories',
            params: payload,
        }).then(() => {
            dispatch('getCategories');
        }),
    updateCategory: ({ dispatch }, payload) => dispatch('request/put', {
            url: `categories/${payload.id}`,
            params: payload,
        }).then(() => {
            dispatch('getCategories');
        }),
    deleteCategory: ({ dispatch }, id) => dispatch('request/del', {
            url: `categories/${id}`,
        }).then(() => {
            dispatch('getCategories');
        }),
};

const mutations = {
    setCategories: (state, payload) => {
        state.categories = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
