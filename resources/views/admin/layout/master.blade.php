<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Admin Dashboard')</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/assets/images/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/libs/chartist/dist/chartist.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/dist/css/style.min.css') }}">
    @stack('styles')
</head>

<body>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-sidebartype="full" data-boxed-layout="full">

        <!-- Header  -->
        @include('admin.layout.header')

        <!--  Sidebar  -->
        @include('admin.layout.sidebar')

        <!--  Content  -->
        <div class="page-wrapper">
            @yield('breadcrumb')
            <div class="container-fluid">
                @include('admin.layout.alert')
                @yield('content')
            </div>

            <footer class="footer text-center">
                All Rights Reserved by NiceAdmin. Designed and Developed by
                <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>
        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('admin/dist/js/waves.js') }}"></script>
    <script src="{{ asset('admin/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('admin/dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/pages/dashboards/dashboard1.js') }}"></script>

    @stack('scripts')
</body>

</html>