import Vue from "vue";

import SideBar from "./components/core/SideBar.vue";
import Navbar from "./components/core/Navbar";
import App from "./components/core/App";
import PriorityComponent from "./modules/Workorder/components/PriorityComponent";
import StatusComponent from "./modules/Workorder/components/StatusComponent";

// Vue.component("SideBar", () => import("./components/core/SideBar.vue"));
// Vue.component("Navbar", () => import("./components/core/Navbar"));
Vue.component("SideBar", SideBar);
Vue.component("Navbar", Navbar);
// Vue.component("Navbar", Navbar);
// Vue.component("App", App);
Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);