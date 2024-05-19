import axios from "axios";

export default {
    state: () => {
        return {
            locationInstallations: [],
        };
    },
    mutations: {
        setLocationInstallations(state, data) {
            state.locationInstallations = data;
        },
    },
    getters: {
        locationInstallationss: (state) => {
            return state.locationInstallations;
        },
    },

    actions: {
        fetchLocationInstallations({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.location-installations.list"), {
                        params: params,
                    })
                    .then((response) => {
                        commit("setLocationInstallations", response.data.data);                        
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
};
