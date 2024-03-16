"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_core_SideBar_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/SideBar.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/SideBar.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _json_menu_json__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../json/menu.json */ "./resources/json/menu.json");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      sideBarLinks: {
        routes: _json_menu_json__WEBPACK_IMPORTED_MODULE_0__
      }
    };
  },
  methods: {
    toggleMenu: function toggleMenu(index) {
      var keySubmenu = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      this.sideBarLinks.routes.forEach(function (group) {
        group.group_menu.forEach(function (menu, i) {
          menu.active = i === index;
          console.log(index, keySubmenu);
          if (menu.child_routes && menu.child_routes.length) {
            menu.child_routes.forEach(function (submenu, key) {
              return submenu.active = i === index && key === keySubmenu;
            });
          }
        });
      });
    }
  },
  mounted: function mounted() {
    console.log(_json_menu_json__WEBPACK_IMPORTED_MODULE_0__);
    this.$nextTick().then(function () {
      var main = document.createElement("script");
      main.setAttribute("defer", "");
      main.setAttribute("src", "assets/main.js");
      document.body.appendChild(main);
    });
  }
});

/***/ }),

/***/ "./resources/js/components/core/SideBar.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/core/SideBar.vue ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SideBar_vue_vue_type_template_id_d665fb12___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SideBar.vue?vue&type=template&id=d665fb12& */ "./resources/js/components/core/SideBar.vue?vue&type=template&id=d665fb12&");
/* harmony import */ var _SideBar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SideBar.vue?vue&type=script&lang=js& */ "./resources/js/components/core/SideBar.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SideBar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SideBar_vue_vue_type_template_id_d665fb12___WEBPACK_IMPORTED_MODULE_0__.render,
  _SideBar_vue_vue_type_template_id_d665fb12___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/core/SideBar.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/core/SideBar.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/core/SideBar.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SideBar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SideBar.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/SideBar.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SideBar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/core/SideBar.vue?vue&type=template&id=d665fb12&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/core/SideBar.vue?vue&type=template&id=d665fb12& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SideBar_vue_vue_type_template_id_d665fb12___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SideBar_vue_vue_type_template_id_d665fb12___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SideBar_vue_vue_type_template_id_d665fb12___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SideBar.vue?vue&type=template&id=d665fb12& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/SideBar.vue?vue&type=template&id=d665fb12&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/SideBar.vue?vue&type=template&id=d665fb12&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/SideBar.vue?vue&type=template&id=d665fb12& ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "aside",
    {
      staticClass: "layout-menu menu-vertical menu bg-menu-theme",
      attrs: { id: "layout-menu" },
    },
    [
      _c("div", { staticClass: "app-brand demo" }, [
        _c(
          "a",
          { staticClass: "app-brand-link", attrs: { href: "index.html" } },
          [
            _c("span", { staticClass: "app-brand-logo demo" }, [
              _c(
                "svg",
                {
                  attrs: {
                    width: "25",
                    viewBox: "0 0 25 42",
                    version: "1.1",
                    xmlns: "http://www.w3.org/2000/svg",
                    "xmlns:xlink": "http://www.w3.org/1999/xlink",
                  },
                },
                [
                  _c("defs", [
                    _c("path", {
                      attrs: {
                        d: "M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z",
                        id: "path-1",
                      },
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d: "M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z",
                        id: "path-3",
                      },
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d: "M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z",
                        id: "path-4",
                      },
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d: "M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z",
                        id: "path-5",
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _c(
                    "g",
                    {
                      attrs: {
                        id: "g-app-brand",
                        stroke: "none",
                        "stroke-width": "1",
                        fill: "none",
                        "fill-rule": "evenodd",
                      },
                    },
                    [
                      _c(
                        "g",
                        {
                          attrs: {
                            id: "Brand-Logo",
                            transform: "translate(-27.000000, -15.000000)",
                          },
                        },
                        [
                          _c(
                            "g",
                            {
                              attrs: {
                                id: "Icon",
                                transform: "translate(27.000000, 15.000000)",
                              },
                            },
                            [
                              _c(
                                "g",
                                {
                                  attrs: {
                                    id: "Mask",
                                    transform: "translate(0.000000, 8.000000)",
                                  },
                                },
                                [
                                  _c(
                                    "mask",
                                    { attrs: { id: "mask-2", fill: "white" } },
                                    [
                                      _c("use", {
                                        attrs: { "xlink:href": "#path-1" },
                                      }),
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c("use", {
                                    attrs: {
                                      fill: "#696cff",
                                      "xlink:href": "#path-1",
                                    },
                                  }),
                                  _vm._v(" "),
                                  _c(
                                    "g",
                                    {
                                      attrs: {
                                        id: "Path-3",
                                        mask: "url(#mask-2)",
                                      },
                                    },
                                    [
                                      _c("use", {
                                        attrs: {
                                          fill: "#696cff",
                                          "xlink:href": "#path-3",
                                        },
                                      }),
                                      _vm._v(" "),
                                      _c("use", {
                                        attrs: {
                                          "fill-opacity": "0.2",
                                          fill: "#FFFFFF",
                                          "xlink:href": "#path-3",
                                        },
                                      }),
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "g",
                                    {
                                      attrs: {
                                        id: "Path-4",
                                        mask: "url(#mask-2)",
                                      },
                                    },
                                    [
                                      _c("use", {
                                        attrs: {
                                          fill: "#696cff",
                                          "xlink:href": "#path-4",
                                        },
                                      }),
                                      _vm._v(" "),
                                      _c("use", {
                                        attrs: {
                                          "fill-opacity": "0.2",
                                          fill: "#FFFFFF",
                                          "xlink:href": "#path-4",
                                        },
                                      }),
                                    ]
                                  ),
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "g",
                                {
                                  attrs: {
                                    id: "Triangle",
                                    transform:
                                      "translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ",
                                  },
                                },
                                [
                                  _c("use", {
                                    attrs: {
                                      fill: "#696cff",
                                      "xlink:href": "#path-5",
                                    },
                                  }),
                                  _vm._v(" "),
                                  _c("use", {
                                    attrs: {
                                      "fill-opacity": "0.2",
                                      fill: "#FFFFFF",
                                      "xlink:href": "#path-5",
                                    },
                                  }),
                                ]
                              ),
                            ]
                          ),
                        ]
                      ),
                    ]
                  ),
                ]
              ),
            ]),
            _vm._v(" "),
            _c(
              "span",
              { staticClass: "app-brand-text demo menu-text fw-bolder ms-2" },
              [_vm._v("Sneat")]
            ),
          ]
        ),
        _vm._v(" "),
        _vm._m(0),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "menu-inner-shadow" }),
      _vm._v(" "),
      _c(
        "ul",
        { staticClass: "menu-inner py-1" },
        [
          _vm._l(_vm.sideBarLinks.routes, function (group, g) {
            return [
              _c(
                "li",
                {
                  key: group.group_name + g,
                  staticClass: "menu-header small text-uppercase",
                },
                [
                  _c("span", { staticClass: "menu-header-text" }, [
                    _vm._v(_vm._s(group.group_name)),
                  ]),
                ]
              ),
              _vm._v(" "),
              _vm._l(group.group_menu, function (menu, index) {
                return [
                  menu.child_routes && menu.child_routes.length
                    ? _c(
                        "li",
                        {
                          key: index,
                          class: ["menu-item", { "active open": menu.active }],
                        },
                        [
                          _c(
                            "a",
                            {
                              class: [
                                "menu-link menu-toggle",
                                { "active ": menu.active },
                              ],
                              attrs: { href: "javascript:void(0);" },
                            },
                            [
                              _c("i", {
                                staticClass: "menu-icon tf-icons bx",
                                class: menu.menu_icon,
                              }),
                              _vm._v(" "),
                              _c("div", [_vm._v(_vm._s(menu.menu_title))]),
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "ul",
                            { staticClass: "menu-sub" },
                            _vm._l(menu.child_routes, function (subMenu, key) {
                              return _c(
                                "router-link",
                                {
                                  key: key,
                                  class: [
                                    "menu-item",
                                    { active: subMenu.active },
                                  ],
                                  attrs: {
                                    tag: "li",
                                    to: { name: subMenu.name },
                                  },
                                },
                                [
                                  _c(
                                    "a",
                                    {
                                      staticClass: "menu-link",
                                      attrs: { href: "javascript:void(0);" },
                                      on: {
                                        click: function ($event) {
                                          return _vm.toggleMenu(index, key)
                                        },
                                      },
                                    },
                                    [
                                      _c("span", [
                                        _vm._v(_vm._s(subMenu.menu_title)),
                                      ]),
                                    ]
                                  ),
                                ]
                              )
                            }),
                            1
                          ),
                        ]
                      )
                    : _c(
                        "router-link",
                        {
                          key: index,
                          class: ["menu-item ", { active: menu.active }],
                          attrs: { to: { name: menu.name }, tag: "li" },
                        },
                        [
                          _c(
                            "a",
                            {
                              staticClass: "menu-link",
                              attrs: { href: "javascript:void(0);" },
                              on: {
                                click: function ($event) {
                                  return _vm.toggleMenu(index)
                                },
                              },
                            },
                            [
                              _c("i", {
                                staticClass: "menu-icon tf-icons bx",
                                class: menu.menu_icon,
                              }),
                              _vm._v(" "),
                              _c("div", [_vm._v(_vm._s(menu.menu_title))]),
                            ]
                          ),
                        ]
                      ),
                ]
              }),
            ]
          }),
        ],
        2
      ),
    ]
  )
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "a",
      {
        staticClass:
          "layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none",
        attrs: { href: "javascript:void(0);" },
      },
      [_c("i", { staticClass: "bx bx-chevron-left bx-sm align-middle" })]
    )
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/json/menu.json":
/*!**********************************!*\
  !*** ./resources/json/menu.json ***!
  \**********************************/
/***/ ((module) => {

module.exports = JSON.parse('[{"group_name":"Menu","group_menu":[{"name":"home","menu_title":"Dashboard","menu_icon":"bx-home-circle","active":true},{"menu_title":"User Management","menu_icon":"bxs-user-circle","child_routes":[{"name":"users.index","menu_title":"User","active":false},{"name":"roles.index","menu_title":"Role","active":false}],"active":false},{"menu_title":"Task Management","menu_icon":"bxs-notepad","child_routes":[{"name":"tasks.index","menu_title":"Task","active":false}],"active":false}]}]');

/***/ })

}]);