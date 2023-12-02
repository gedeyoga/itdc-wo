import axios from "axios";

export default {
    state: () => {
        return {
            tasks: [],
        };
    },
    mutations: {
        setTasks(state, data) {
            state.tasks = data;
        },
    },
    getters: {
        tasks: (state) => {
            return state.tasks;
        },
    },

    actions: {
        fetchTasks({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.task.list"), {
                        params: params,
                    })
                    .then((response) => {
                        commit("setTasks", response.data.data);
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
};
