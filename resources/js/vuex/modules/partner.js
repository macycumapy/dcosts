const state = {
  partners: [],
};

const getters = {
  partners: state => state.partners,
};

const actions = {
  getPartners: ({commit, dispatch}) => {
    dispatch('request/get', {
      url: 'partners',
    }).then((data) => {
      commit('setPartners', data.data);
    });
  },
  addPartner: ({dispatch}, payload) => dispatch('request/post', {
    url: 'partners',
    params: payload,
  }).then(() => {
    dispatch('getPartners');
  }),
  updatePartner: ({dispatch}, payload) => dispatch('request/put', {
    url: `partners/${payload.id}`,
    params: payload,
  }).then(() => {
    dispatch('getPartners');
  }),
  deletePartner: ({dispatch}, id) => dispatch('request/del', {
    url: `partners/${id}`,
  }).then(() => {
    dispatch('getPartners');
  }),
};

const mutations = {
  setPartners: (state, payload) => {
    state.partners = payload;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
