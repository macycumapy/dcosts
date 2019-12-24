const state = {
    partners: [],
};

const getters = {
    getPartners: state => state.partners
};

const actions = {
    getPartners: ({commit, dispatch}) => {
        dispatch('getRequest', {
            url: 'partner'
        }).then((resp) => {
            commit('updatePartners', resp);
        });
    },
    addPartner: ({dispatch},payload) => {
        dispatch('postRequest', {
            url: 'partner',
            params:payload
        }).then(() => {
            dispatch('getPartners')
        });
    },
    updatePartner: ({dispatch},payload) => {
        dispatch('putRequest', {
            url: 'partner/'+payload.id,
            params:payload
        }).then(() => {
            dispatch('getPartners')
        });
    },
    deletePartner: ({dispatch},id) => {
        dispatch('delRequest', {
            url: 'partner/'+id
        }).then(() => {
            dispatch('getPartners')
        });
    },
};

const mutations = {
    updatePartners: (state, payload) => {
        state.partners = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
}
