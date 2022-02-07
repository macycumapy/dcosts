const state = {
  title: 'Title',
};

const getters = {
  title: state => state.title,
};

const mutations = {
  setTitle: (state, payload) => {
    state.title = payload;
    document.title = `Daily costs | ${payload}`;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
};
