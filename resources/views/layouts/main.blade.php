<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed layout-compact" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ Auth::user()->getAuthToken() }}">
    <meta name="base-url" content="{{ url('/') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons. Uncomment required icon fonts -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" /> -->

    <!-- Core CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" /> -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" /> -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" /> -->

    <!-- Vendors CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" /> -->

    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" /> -->

    <!-- Helpers -->
    <!-- <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script> -->

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <!-- <script src="{{ asset('assets/js/config.js') }}"></script> -->

    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
</head>

<body>
    <!-- <div id="app">
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
    </div> -->

    <div id="app"></div>

    @routes

    <script>
        window.admin_panel = {
            user: {!!$user!!},
        };
    </script>

    <!-- Scripts -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <!-- <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script> -->
    <!-- endbuild -->

    <!-- Vendors JS -->
    <!-- <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script> -->

    <!-- Main JS -->
    <!-- <script async defer src="{{ asset('assets/vendor/js/menu.js') }}"></script> -->
    <!-- <script async defer src="{{ asset('assets/js/main.js') }}"></script> -->


    <!-- Page JS -->
    <!-- <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script> -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->
    <script async defer src="{{mix('/js/manifest.js')}}"></script>
    <script async defer src="{{mix('/js/vendor.js')}}"></script>
    <script async defer src="{{mix('/js/app.js')}}"></script>

</body>

</html>