import { Helpers } from "../template/js/helpers.js";
window.Helpers = Helpers;
import config from "../template/assets/js/config.js";
window.config = config;
import { $, jQuery} from "../template/libs/jquery/jquery";
window.$ = $;
window.jQuery = jQuery;

require("../template/assets/vendor/libs/popper/popper.js");
require("../template/js/bootstrap.js");
require("../template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js");
// require("../template/js/menu.js");
require("../template/assets/vendor/libs/apex-charts/apexcharts.js");
// require("../template/assets/js/main.js");
require("../template/assets/js/dashboards-analytics.js");
