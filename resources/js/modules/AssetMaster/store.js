import axios from "axios";

export default {
    state: () => {
        return {
            asset_masters: [],
        };
    },
    mutations: {
        setAssetMasters(state, data) {
            state.asset_masters = data;
        },
    },
    getters: {
        asset_masters: (state) => {
            return state.asset_masters;
        },
    },

    actions: {
        fetchAssetMasters({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.asset-masters.list"), {
                        params: {
                            ...params,
                            status: 'active',
                        },
                    })
                    .then((response) => {
                        commit("setAssetMasters", response.data.data);
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
};
