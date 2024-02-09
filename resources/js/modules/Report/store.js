import axios from "axios";

export default {
    state: () => {
        return {
            tasks: [],
            task: {},
        };
    },
    mutations: {
        setTasks(state, data) {
            state.tasks = data;
        },
        setTask(state, data) {
            state.task = data;
        },
    },
    getters: {
        tasks: (state) => {
            return state.tasks;
        },
        task: (state) => {
            return state.task;
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

        findTask({commit} , task_id) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.task.show" , {
                        task: task_id,
                    }))
                    .then((response) => {
                        commit("setTask", response.data.data);
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        }
    },
};
