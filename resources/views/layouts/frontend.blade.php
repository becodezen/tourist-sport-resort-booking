<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', $page_title)</title>
    {{--  add plugin  --}}
    @stack('plugin-styles')
    <!-- vendors -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendors/animate.css/animate.min.css') }}">

    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
</head>

<body>

    @include('partials._fr_header')

    @yield('content')

    @include('partials._fr_footer')


    <!-- Jquery -->
    <script src="{{ asset('frontend/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootsttrap -->
    <script src="{{ asset('frontend/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FontAwesome -->
    <script src="{{ asset('frontend/vendors/@fortawesome/fontawesome-free/js/all.min.js') }}"></script>
    <!-- Owl-Carousel -->
    <script src="{{ asset('frontend/vendors/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <!-- Slick Carousel -->
    <script src="{{ asset('frontend/vendors/slick-carousel/slick/slick.min.js') }}"></script>
    <!-- Parallax Js -->
    <script src="{{ asset('frontend/vendors/jquery-parallax.js/parallax.min.js') }}"></script>
    <!-- Submitter Js -->
    <script src="{{ asset('assets/js/submitter.js') }}"></script>
    <script src="{{ asset('assets/js/booking-submitter.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    {{--  add plugin  --}}
    @stack('plugin-scripts')
    <!-- Custom Js -->
    <script src="{{ asset('frontend/assets/js/custom.js') }}"></script>

    @stack('footer-scripts')
</body>

</html>
