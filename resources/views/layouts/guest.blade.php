<!DOCTYPE html>
<html lang="">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="csrf_token()">
        <title>{{ config('settings.product_name') }} - @yield('title')</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
        <link rel="shortcut icon" href="{{ asset('storage/app/public/assets/favicon/favicon.png') }}" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.6/sweetalert2.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

        @stack('styles-header')
        @stack('scripts-header')

    </head>

    <body>
        <div id="auth">

            <div class="container">
                <div class="row d-flex">
                    <div class="col-md-8 col-lg-6 col-xl-5 col-sm-12 mx-auto">
                        <div class="card pt-4">
                            <div class="card-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script>
            "use strict";
            var csrf_token = '{{ csrf_token() }}';
            var url_login = '{{ route('login') }}'
            var url_register = '{{ route('register') }}';
            var url_dashboard = '{{ route('dashboard.index') }}';
            var success = '{{ __('success') }}';
            var warning = '{{ __('warning') }}';
            var error = '{{ __('error') }}';
        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/js/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.6/sweetalert2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="{{ asset('assets/js/common/common.js') }}"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="{{ asset('assets/css/guest.css') }}">

        @stack('scripts-footer')
        @stack('styles-footer')

    </body>

</html>
