const state = {
    nomenclature: [],
};

const getters = {
    getNomenclature: state => state.nomenclature
};

const actions = {
    getNomenclature: ({commit, dispatch}) => {
        dispatch('getRequest', {
            url: 'nomenclature'
        }).then((resp) => {
            commit('updateNomenclature', resp);
        });
    },
    addNomenclature: ({dispatch},payload) => {
        dispatch('postRequest', {
            url: 'nomenclature',
            params:payload
        }).then(() => {
            dispatch('getNomenclature')
        });
    },
    updateNomenclature: ({dispatch},payload) => {
        dispatch('putRequest', {
            url: 'nomenclature/'+payload.id,
            params:payload
        }).then(() => {
            dispatch('getNomenclature')
        });
    },
    deleteNomenclature: ({dispatch},id) => {
        dispatch('delRequest', {
            url: 'nomenclature/'+id
        }).then(() => {
            dispatch('getNomenclature')
        });
    },
};

const mutations = {
    updateNomenclature: (state, payload) => {
        state.nomenclature = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
}
