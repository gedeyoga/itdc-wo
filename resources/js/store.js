// State Import
import Vue from "vue";
import Vuex from "vuex";
import Priority from "./modules/Priority/store";
import TaskCategory from "./modules/TaskCategory/store";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        Priority,
        TaskCategory,
    },
});

export default store;
