const state = {
  nomenclature: [],
};

const getters = {
  nomenclature: state => state.nomenclature,
};

const actions = {
  getNomenclature: ({ dispatch, commit }) => {
    dispatch('request/get', {
      url: 'nomenclatures',
    })
      .then((data) => {
        commit('setNomenclature', data.data);
      });
  },

  addNomenclature: ({ dispatch }, payload) => {
    dispatch('request/post', {
      url: 'nomenclatures',
      params: payload,
    })
      .finally(() => {
        dispatch('getNomenclature');
      });
  },
  updateNomenclature: ({ dispatch }, payload) => {
    dispatch('request/put', {
      url: `nomenclatures/${payload.id}`,
      params: payload,
    })
      .finally(() => {
        dispatch('getNomenclature');
      });
  },
  deleteNomenclature: ({ dispatch }, id) => {
    dispatch('request/del', {
      url: `nomenclatures/${id}`,
    })
      .finally(() => {
        dispatch('getNomenclature');
      });
  },
};

const mutations = {
  setNomenclature: (state, payload) => {
    state.nomenclature = payload;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
