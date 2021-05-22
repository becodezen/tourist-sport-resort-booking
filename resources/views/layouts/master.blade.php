<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- Page title -->
    <title>@yield('page_title', $page_title)</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}">
    {{--  sweetalert2  --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert2.min.css') }}">
    @stack('plugin-styles')
    <!-- css files from plugins -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-4.5.3/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome/css/all.min.css') }}">
    {{-- default style --}}
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
    <!-- master stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- custom stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @stack('header-styles')
</head>
<body>

<!-- page wrapper area -->
<div class="page-wrapper">
    @include('partials.header')
    <!-- main-content page area -->
    <section class="page-content-area">
        @if(Auth::user()->role()->name === 'super_admin')
            @include('partials.sidebar')
        @elseif(Auth::user()->role()->name === 'admin')
            @include('partials.sidebar-resort-admin')
        @elseif(Auth::user()->role()->name === 'manager')
            @include('partials.sidebar-resort-manager')
        @endif

        <!-- main-content -->
        <div class="main-content-area">
{{--            <!-- page title -->--}}
{{--            <div class="page-info">--}}
{{--                <div class="container-fluid">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-lg-12">--}}
{{--                            <h3 class="page-title">@yield('page_title', $page_title)</h3>--}}
{{--                            <p class="page-description">Home / Dashboard</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>

    <!-- footer -->
</div>

<!-- jquery plugins -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-4.5.3/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/navigation.js') }}"></script>
<script src="{{ asset('assets/js/submitter.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert2.min.js') }}"></script>
{{--<script--}}
{{--    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBC2Hvbc0wgDamk6KD2xprGUMi1x5hpPEs&callback=initMap&libraries=&v=weekly"--}}
{{--    async--}}
{{--></script>--}}
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBC2Hvbc0wgDamk6KD2xprGUMi1x5hpPEs&callback=initMap" async defer></script>
{{--<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBC2Hvbc0wgDamk6KD2xprGUMi1x5hpPEs"></script>--}}
@stack('plugin-scripts')
<script src="{{ asset('assets/js/custom.js') }}"></script>
@stack('footer-scripts')
</body>
</html>
