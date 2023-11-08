<template>
    <div>
        <!-- <router-view></router-view> -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <side-bar></side-bar>

                <div class="layout-page">
                    <navbar></navbar>

                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                           <router-view></router-view>
                        </div>
                        <footer class="content-footer footer bg-footer-theme">
                            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    ©
                                    , made with ❤️ by
                                    <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                                </div>
                                <div>
                                    <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                                    <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                                    <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>

                                    <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues" target="_blank" class="footer-link me-4">Support</a>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

require("../../mixins.js");
require("../../components.js");

export default {
    data() {
        return {
            input: null,
        };
    },
};
</script>