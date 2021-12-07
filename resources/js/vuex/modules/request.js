const actions = {
  get: ({ dispatch }, payload) => new Promise((resolve, reject) => {
      dispatch('preloader/show', '', { root: true });
      axios.get(`/api/${payload.url}`)
        .then((response) => {
          resolve(response.data);
        })
        .catch((err) => {
          toastr.error(err.response.data.message);
          reject(err);
        })
        .finally(() => {
          dispatch('preloader/hide', '', { root: true });
        });
    }),
  post: ({ dispatch }, payload) => new Promise((resolve, reject) => {
      dispatch('preloader/show', '', { root: true });
      axios.post(`/api/${payload.url}`, payload.params)
        .then((response) => {
          resolve(response.data);
        })
        .catch((err) => {
          toastr.error(err.response.data.message);
          reject(err);
        })
        .finally(() => {
          dispatch('preloader/hide', '', { root: true });
        });
    }),
  put: ({ dispatch }, payload) => new Promise((resolve, reject) => {
      dispatch('preloader/show', '', { root: true });
      axios.put(`/api/${payload.url}`, payload.params)
        .then((response) => {
          resolve(response.data);
        })
        .catch((err) => {
          toastr.error(err.response.data.message);
          reject(err);
        })
        .finally(() => {
          dispatch('preloader/hide', '', { root: true });
        });
    }),
  del: ({ dispatch }, payload) => new Promise((resolve, reject) => {
      dispatch('preloader/show', '', { root: true });
      axios.delete(`/api/${payload.url}`)
        .then((response) => {
          resolve(response.data);
        })
        .catch((err) => {
          toastr.error(err.response.data.message);
          reject(err);
        })
        .finally(() => {
          dispatch('preloader/hide', '', { root: true });
        });
    }),
};

export default {
  actions,
  namespaced: true,
};
