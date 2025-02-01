import axios from "axios";

export default {
    state: () => {
        return {
            minute_counters: [],
        };
    },
    mutations: {
        setMinuteCounters(state, data) {
            state.minute_counters = data;
        },
    },
    getters: {
        minute_counters: (state) => {
            return state.minute_counters;
        },
    },

    actions: {
        fetchMinuteCounters({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.minute_counters.list"), {
                        params: params,
                    })
                    .then((response) => {
                        commit("setMinuteCounters", response.data.data);
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
};
