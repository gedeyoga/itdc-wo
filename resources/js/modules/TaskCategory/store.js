import axios from "axios";

export default {
    state: () => {
        return {
            task_categories: [],
        };
    },
    mutations: {
        setTaskCategories(state, data) {
            state.task_categories = data;
        },
    },
    getters: {
        task_categories: (state) => {
            return state.task_categories;
        },
    },

    actions: {
        fetchTaskCategories({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.task-categories.list"), {
                        params: {},
                    })
                    .then((response) => {
                        commit("setTaskCategories", response.data.data);                        
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
};
