
const state = {

};

const getters = {

};

const actions = {
    getRequest: ({dispatch}, payload) => {
        return new Promise((resolve, reject) => {
            axios.get('/api/' + payload.url)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        })
    },
    postRequest: ({dispatch}, payload) => {
        return new Promise((resolve, reject) => {
            axios.post('/api/' + payload.url, payload.params)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        });
    },
    putRequest: ({dispatch}, payload) => {
        return new Promise((resolve, reject) => {
            axios.put('/api/' + payload.url, payload.params)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        });
    },
    delRequest: ({dispatch}, payload) => {
        return new Promise((resolve, reject) => {
            axios.delete('/api/' + payload.url)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((err) => {
                    reject(err);
                })
        });
    },
};

const mutations = {

};

export default {
    state,
    getters,
    actions,
    mutations
}
