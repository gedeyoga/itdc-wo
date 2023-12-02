import axios from "axios";

export default {
    state: () => {
        return {
            // task_categories: [],
        };
    },
    mutations: {
        // setTaskCategories(state, data) {
        //     state.task_categories = data;
        // },
    },
    getters: {
        // task_categories: (state) => {
        //     return state.task_categories;
        // },
    },

    actions: {
        fetchUsers({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get(route("api.user.index"), {
                        params: params,
                    })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
};
