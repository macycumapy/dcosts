const state = {
    nomenclature_type: [],
};

const getters = {
    getNomenclatureType: state => state.nomenclature_type
};

const actions = {
    getNomenclatureType: ({commit, dispatch}) => {
        dispatch('getRequest', {
            url: 'nomenclature_types'
        }).then((resp) => {
            commit('updateNomenclatureType', resp);
        });
    },
    addNomenclatureType: ({dispatch},payload) => {
        dispatch('postRequest', {
            url: 'nomenclature_types',
            params:payload
        }).then(() => {
            dispatch('getNomenclatureType')
        });
    },
    updateNomenclatureType: ({dispatch},payload) => {
        dispatch('putRequest', {
            url: 'nomenclature_types/'+payload.id,
            params:payload
        }).then(() => {
            dispatch('getNomenclatureType')
        });
    },
    deleteNomenclatureType: ({dispatch},id) => {
        dispatch('delRequest', {
            url: 'nomenclature_types/'+id
        }).then(() => {
            dispatch('getNomenclatureType')
        });
    },
};

const mutations = {
    updateNomenclatureType: (state, payload) => {
        state.nomenclature_type = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
}
