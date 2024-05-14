import axios from "axios";

export default {
    state: () => {
        return {
            tenant: [],
        };
    },
    mutations: {
        setTenants(state, data) {
            state.tenant = data;
        },
    },
    getters: {
        tenant: (state) => {
            return state.tenant;
        },
    },

    actions: {
        fetchTenants({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.tenant.list"), {
                        params: params,
                    })
                    .then((response) => {
                        commit("setTenants", response.data.data);                        
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
};
