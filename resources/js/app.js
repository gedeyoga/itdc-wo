// require("./bootstrap");
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require("vue").default;

import "../css/theme/index.css";
import ElementUI from "element-ui";
import locale from "element-ui/lib/locale/lang/en";
import Vue from "vue";
import App from "./components/core/App";
import routes from "./routes";
import imagePreview from "image-preview-vue";
import "image-preview-vue/lib/imagepreviewvue.css";
import store from "./store.js"; 
import axios from "axios";

require("./filters");
require("./components");

import { Helpers } from "../template/js/helpers.js";
window.Helpers = Helpers;
import config from "../template/assets/js/config.js";
window.config = config;
import { $, jQuery } from "../template/libs/jquery/jquery";
window.$ = $;
window.jQuery = jQuery;

require("../template/assets/vendor/libs/popper/popper.js");
require("../template/js/bootstrap.js");
require("../template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js");
require("../template/js/menu.js");
require("../template/assets/vendor/libs/apex-charts/apexcharts.js");
// require("../template/assets/js/main.js");
require("../template/assets/js/dashboards-analytics.js");


axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

const userApiToken = localStorage.getItem("token");

if (userApiToken) {
    axios.defaults.headers.common.Authorization = `Bearer ${userApiToken}`;
} else {
    console.error("User API token not found in a meta tag.");
}

Vue.use(ElementUI, { locale });
Vue.use(imagePreview);

let base_url = document.head.querySelector('meta[name="base-url"]');

if (base_url) {
    base_url = base_url.content;
}
Vue.prototype.$url = base_url;
Vue.prototype.$csrfToken = token;
Vue.prototype.$api_token = userApiToken;

axios.interceptors.response.use(null, (error) => {
    if (error.response === undefined) {
        return;
    }
    if (error.response.status === 403) {
        app.$message.error(
            "Sesi telah berakhir!. silahkan login terlebih dahulu!"
        );
        axios.post(route("logout")).then((response) => {
            window.location = response.data.redirect;
        });
    }
    if (error.response.status === 401) {
        app.$message.error("Silahkan login terlebih dahulu!");
        axios.post(route("logout")).then((response) => {
            window.location = response.data.redirect;
        });
    }

    if (error.response.status === 500) {
        app.$message.error({
            // title: app.$t("core.internal server error"),
            message: "Terjadi kesalahan pada sistem!",
        });
    }

    return Promise.reject(error);
});

window.axios = axios;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: "#app",
    router: routes,
    store,
    render: (h) => h(App)
});



