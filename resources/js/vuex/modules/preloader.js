const state = {
    show: false,
};

const getters = {
    show: state => state.show,
};

const actions = {
    show: ({ commit }) => {
        commit('setShow', true);
    },
    hide: ({ commit }) => {
        commit('setShow', false);
    },
};

const mutations = {
    setShow: (state, show) => {
        state.show = show;
    },
};

export default {
    namespaced: true,
        state,
        getters,
        actions,
        mutations,
    };
