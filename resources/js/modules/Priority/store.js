import axios from "axios";

export default {
    state: () => {
        return {
            priorities: [],
        };
    },
    mutations: {
        setPriorities(state, data) {
            state.priorities = data;
        },
    },
    getters: {
        priorities: (state) => {
            return state.priorities;
        },
    },

    actions: {
        fetchPriorities({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.priorities.list"), {
                        params: {},
                    })
                    .then((response) => {
                        commit("setPriorities", response.data.data);                        
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
};
