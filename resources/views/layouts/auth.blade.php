<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SB Admin 2 - Login</title>

    <!-- Icons. Uncomment required icon fonts -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" /> -->

    <!-- Core CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" /> -->

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

<body class="bg-gradient-primary">

    <div id="app"></div>


    @routes

    <!-- <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script> -->
    <!-- endbuild -->

    <!-- Vendors JS -->
    <!-- <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script> -->

    <!-- Main JS -->
    <!-- <script src="{{ asset('assets/js/main.js') }}"></script> -->

    <!-- Page JS -->
    <!-- <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script> -->

    <!-- Scripts -->
    <script defer src="{{mix('/js/manifest.js')}}"></script>
    <script defer src="{{mix('/js/vendor.js')}}"></script>
    <script defer src="{{mix('/js/app.js')}}"></script>
</body>

</html>