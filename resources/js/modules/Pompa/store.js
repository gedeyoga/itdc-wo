import axios from "axios";

export default {
    state: () => {
        return {
            pompas: [],
        };
    },
    mutations: {
        setPompas(state, data) {
            state.pompas = data;
        },
    },
    getters: {
        pompas: (state) => {
            return state.pompas;
        },
    },

    actions: {
        fetchPompas({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.pompas.list"), {
                        params: params,
                    })
                    .then((response) => {
                        commit("setPompas", response.data.data);
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
};
