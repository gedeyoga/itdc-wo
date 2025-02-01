import Vue from "vue";
import VueRouter from "vue-router";

import UserRoutes from "./modules/User/UserRoutes";
import RoleRoutes from "./modules/Role/RoleRoutes";
import DashboardRoutes from "./modules/Dashboard/DashboardRoutes";
import TaskRoutes from "./modules/Task/TaskRoutes";
import TaskCategoryRoutes from "./modules/TaskCategory/TaskCategoryRoutes";
import WorkorderRoutes from "./modules/Workorder/WorkorderRoutes";
import TaskScheduleRoutes from "./modules/TaskSchedule/TaskScheduleRoutes";
import ReportRoutes from "./modules/Report/ReportRoutes";
import LocationRoutes from "./modules/Location/LocationRoutes";
import PompaRoutes from "./modules/Pompa/PompaRoutes";
import LocationInstallationRoutes from "./modules/LocationInstallation/LocationInstallationRoutes";
import TenantRoutes from "./modules/Tenant/TenantRoutes";
import HistoryRoutes from "./modules/History/HistoryRoutes";


Vue.use(VueRouter);

const routes = [
    ...DashboardRoutes,
    ...UserRoutes,
    ...RoleRoutes,
    ...TaskRoutes,
    ...TaskCategoryRoutes,
    ...WorkorderRoutes,
    ...TaskScheduleRoutes,
    ...ReportRoutes,
    ...LocationRoutes,
    ...PompaRoutes,
    ...LocationInstallationRoutes,
    ...TenantRoutes,
    ...HistoryRoutes,
];

const router = new VueRouter({
    mode: "history",
    routes: routes,
});

export default router;