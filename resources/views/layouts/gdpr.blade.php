<!DOCTYPE html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>@yield('title')</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/app/public/assets/favicon/favicon.png') }}"/>

    <!-- ======== CSS here ======== -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/landing/css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/landing/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/landing/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/pages/site.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.6/sweetalert2.css" />
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    @stack('styles-header')
    @stack('scripts-footer')
  </head>
  <body>
    <!-- ======== header start ======== -->
    @include('landing.header')
    <!-- ======== header end ======== -->

    @yield('content')

    <!-- ======== footer start ======== -->
    @include('landing.footer')
    <!-- ======== footer end ======== -->

    <!-- ======== scroll-top ======== -->
    <a href="#" class="scroll-top btn-hover"><i class="lni lni-chevron-up"></i></a>

    <?php  $get_value = isset($_GET['site']) ? $_GET['site'] : ""; ?>
    

    <!-- ======== JS here ======== -->
    <script src="{{ asset('assets/landing/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.6/sweetalert2.min.js"></script>
    
    <script src="{{ asset('assets/js/pages/site.js') }}"></script>
    @stack('styles-footer')
    @stack('scripts-footer')
  </body>
</html>
