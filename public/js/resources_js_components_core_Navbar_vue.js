"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_core_Navbar_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/Navbar.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/Navbar.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
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
  methods: {
    logout: function logout() {
      axios.post(route("logout"), {}, {
        headers: {
          Accept: "application/json" //the token is a variable which holds the token
        }
      }).then(function (response) {
        window.location.href = response.data.redirect;
      });
    },
    dialogLogout: function dialogLogout() {
      var _this = this;
      this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
        confirmButtonText: 'Logout',
        cancelButtonText: 'Batal',
        type: 'warning'
      }).then(function () {
        _this.logout();
      })["catch"](function () {});
    },
    handlePreviewWebsite: function handlePreviewWebsite() {
      window.open(this.$url, "_blank");
    }
  }
});

/***/ }),

/***/ "./resources/js/components/core/Navbar.vue":
/*!*************************************************!*\
  !*** ./resources/js/components/core/Navbar.vue ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Navbar_vue_vue_type_template_id_56ada8b6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Navbar.vue?vue&type=template&id=56ada8b6& */ "./resources/js/components/core/Navbar.vue?vue&type=template&id=56ada8b6&");
/* harmony import */ var _Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Navbar.vue?vue&type=script&lang=js& */ "./resources/js/components/core/Navbar.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Navbar_vue_vue_type_template_id_56ada8b6___WEBPACK_IMPORTED_MODULE_0__.render,
  _Navbar_vue_vue_type_template_id_56ada8b6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/core/Navbar.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/core/Navbar.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/components/core/Navbar.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Navbar.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/Navbar.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/core/Navbar.vue?vue&type=template&id=56ada8b6&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/core/Navbar.vue?vue&type=template&id=56ada8b6& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_56ada8b6___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_56ada8b6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_56ada8b6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Navbar.vue?vue&type=template&id=56ada8b6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/Navbar.vue?vue&type=template&id=56ada8b6&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/Navbar.vue?vue&type=template&id=56ada8b6&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/core/Navbar.vue?vue&type=template&id=56ada8b6& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
    "nav",
    {
      staticClass:
        "layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme",
      attrs: { id: "layout-navbar" },
    },
    [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "navbar-nav-right d-flex align-items-center",
          attrs: { id: "navbar-collapse" },
        },
        [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "ul",
            { staticClass: "navbar-nav flex-row align-items-center ms-auto" },
            [
              _vm._m(2),
              _vm._v(" "),
              _c(
                "li",
                {
                  staticClass:
                    "nav-item navbar-dropdown dropdown-user dropdown",
                },
                [
                  _c(
                    "a",
                    {
                      staticClass: "nav-link dropdown-toggle hide-arrow",
                      attrs: {
                        href: "javascript:void(0);",
                        "data-bs-toggle": "dropdown",
                      },
                    },
                    [
                      _c("div", { staticClass: "avatar avatar-online" }, [
                        _c("img", {
                          staticClass: "w-px-40 h-auto rounded-circle",
                          attrs: {
                            src: _vm.$url + "/assets/img/avatars/1.png",
                            alt: "",
                          },
                        }),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("ul", { staticClass: "dropdown-menu dropdown-menu-end" }, [
                    _c("li", [
                      _c(
                        "a",
                        { staticClass: "dropdown-item", attrs: { href: "#" } },
                        [
                          _c("div", { staticClass: "d-flex" }, [
                            _c("div", { staticClass: "flex-shrink-0 me-3" }, [
                              _c(
                                "div",
                                { staticClass: "avatar avatar-online" },
                                [
                                  _c("img", {
                                    staticClass:
                                      "w-px-40 h-auto rounded-circle",
                                    attrs: {
                                      src:
                                        _vm.$url + "/assets/img/avatars/1.png",
                                      alt: "",
                                    },
                                  }),
                                ]
                              ),
                            ]),
                            _vm._v(" "),
                            _c("div", { staticClass: "flex-grow-1" }, [
                              _c(
                                "span",
                                { staticClass: "fw-semibold d-block" },
                                [_vm._v(_vm._s(_vm.user.name))]
                              ),
                              _vm._v(" "),
                              _c(
                                "small",
                                {
                                  staticClass: "text-muted",
                                  staticStyle: {
                                    "text-transform": "capitalize",
                                  },
                                },
                                [_vm._v(_vm._s(_vm.user.roles[0].name))]
                              ),
                            ]),
                          ]),
                        ]
                      ),
                    ]),
                    _vm._v(" "),
                    _vm._m(3),
                    _vm._v(" "),
                    _vm._m(4),
                    _vm._v(" "),
                    _vm._m(5),
                    _vm._v(" "),
                    _vm._m(6),
                    _vm._v(" "),
                    _vm._m(7),
                    _vm._v(" "),
                    _c("li", [
                      _c(
                        "a",
                        {
                          staticClass: "dropdown-item",
                          attrs: { href: "#" },
                          on: {
                            click: function ($event) {
                              $event.preventDefault()
                              return _vm.dialogLogout.apply(null, arguments)
                            },
                          },
                        },
                        [
                          _c("i", { staticClass: "bx bx-power-off me-2" }),
                          _vm._v(" "),
                          _c("span", { staticClass: "align-middle" }, [
                            _vm._v("Log Out"),
                          ]),
                        ]
                      ),
                    ]),
                  ]),
                ]
              ),
            ]
          ),
        ]
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
      "div",
      {
        staticClass:
          "layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none",
      },
      [
        _c(
          "a",
          {
            staticClass: "nav-item nav-link px-0 me-xl-4",
            attrs: { href: "javascript:void(0)" },
          },
          [_c("i", { staticClass: "bx bx-menu bx-sm" })]
        ),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "navbar-nav align-items-center" }, [
      _c("div", { staticClass: "nav-item d-flex align-items-center" }, [
        _c("i", { staticClass: "bx bx-search fs-4 lh-0" }),
        _vm._v(" "),
        _c("input", {
          staticClass: "form-control border-0 shadow-none",
          attrs: {
            type: "text",
            placeholder: "Search...",
            "aria-label": "Search...",
          },
        }),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("li", { staticClass: "nav-item lh-1 me-3" }, [
      _c(
        "a",
        {
          staticClass: "github-button",
          attrs: {
            href: "https://github.com/themeselection/sneat-html-admin-template-free",
            "data-icon": "octicon-star",
            "data-size": "large",
            "data-show-count": "true",
            "aria-label":
              "Star themeselection/sneat-html-admin-template-free on GitHub",
          },
        },
        [_vm._v("Star")]
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("li", [_c("div", { staticClass: "dropdown-divider" })])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("li", [
      _c("a", { staticClass: "dropdown-item", attrs: { href: "#" } }, [
        _c("i", { staticClass: "bx bx-user me-2" }),
        _vm._v(" "),
        _c("span", { staticClass: "align-middle" }, [_vm._v("My Profile")]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("li", [
      _c("a", { staticClass: "dropdown-item", attrs: { href: "#" } }, [
        _c("i", { staticClass: "bx bx-cog me-2" }),
        _vm._v(" "),
        _c("span", { staticClass: "align-middle" }, [_vm._v("Settings")]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("li", [
      _c("a", { staticClass: "dropdown-item", attrs: { href: "#" } }, [
        _c("span", { staticClass: "d-flex align-items-center align-middle" }, [
          _c("i", { staticClass: "flex-shrink-0 bx bx-credit-card me-2" }),
          _vm._v(" "),
          _c("span", { staticClass: "flex-grow-1 align-middle" }, [
            _vm._v("Billing"),
          ]),
          _vm._v(" "),
          _c(
            "span",
            {
              staticClass:
                "flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20",
            },
            [_vm._v("4")]
          ),
        ]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("li", [_c("div", { staticClass: "dropdown-divider" })])
  },
]
render._withStripped = true



/***/ })

}]);