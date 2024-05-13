import axios from "axios";

export default {
    state: () => {
        return {
            locations: [],
        };
    },
    mutations: {
        setLocations(state, data) {
            state.locations = data;
        },
    },
    getters: {
        locations: (state) => {
            return state.locations;
        },
    },

    actions: {
        fetchLocations({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.locations.list"), {
                        params: params,
                    })
                    .then((response) => {
                        commit("setLocations", response.data.data);                        
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
};
