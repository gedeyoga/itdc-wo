import Vue from "vue";
import VueRouter from "vue-router";

import UserRoutes from "./modules/User/UserRoutes";
import RoleRoutes from "./modules/Role/RoleRoutes";
import DashboardRoutes from "./modules/Dashboard/DashboardRoutes";
import TaskRoutes from "./modules/Task/TaskRoutes";
import TaskCategoryRoutes from "./modules/TaskCategory/TaskCategoryRoutes";


Vue.use(VueRouter);

const routes = [
    ...DashboardRoutes,
    ...UserRoutes,
    ...RoleRoutes,
    ...TaskRoutes,
    ...TaskCategoryRoutes,
];

const router = new VueRouter({
    mode: "history",
    routes: routes,
});

export default router;