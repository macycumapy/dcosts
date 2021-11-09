const state = {
    nomenclatureTypes: [],
};

const getters = {
    nomenclatureTypes: state => state.nomenclatureTypes,
};

const actions = {
    getNomenclatureType: ({ commit, dispatch }) => {
        dispatch('request/get', {
            url: 'nomenclature-types',
        }).then((data) => {
            commit('setNomenclatureType', data.data);
        });
    },
    addNomenclatureType: ({ dispatch }, payload) => {
        dispatch('request/post', {
            url: 'nomenclature-types',
            params: payload,
        }).finally(() => {
            dispatch('getNomenclatureType');
        });
    },
    updateNomenclatureType: ({ dispatch }, payload) => {
        dispatch('request/put', {
            url: `nomenclature-types/${payload.id}`,
            params: payload,
        }).finally(() => {
            dispatch('getNomenclatureType');
        });
    },
    deleteNomenclatureType: ({ dispatch }, id) => {
        dispatch('request/del', {
            url: `nomenclature-types/${id}`,
        }).finally(() => {
            dispatch('getNomenclatureType');
        });
    },
};

const mutations = {
    setNomenclatureType: (state, payload) => {
        state.nomenclatureTypes = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
