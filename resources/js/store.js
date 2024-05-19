// State Import
import Vue from "vue";
import Vuex from "vuex";
import Priority from "./modules/Priority/store";
import TaskCategory from "./modules/TaskCategory/store";
import Location from "./modules/Location/store";
import User from "./modules/User/store";
import Task from "./modules/Task/store";
import Pompa from "./modules/Pompa/store";
import Tenant from "./modules/Tenant/store";
import LocationInstallation from "./modules/LocationInstallation/store";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        Priority,
        TaskCategory,
        Location,
        User,
        Task,
        Pompa,
        Tenant,
        LocationInstallation,
    },
});

export default store;
