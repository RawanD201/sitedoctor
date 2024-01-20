<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="csrf_token()">
        <title>{{ config('settings.product_name') }} - @yield('title')</title>

        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
        <link rel="shortcut icon" href="{{ asset('storage/app/public/assets/favicon/favicon.png') }}" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    </head>

    <body>
        <div id="error">
            <div class="container text-center pt-32">
                <h1 class='error-title text-danger'>@yield('error_code')</h1>
                <p class='error-details my-4 py-4 alert'> @yield('error_details')</p>
                <a href="{{URL::to('/')}}" class='btn btn-dark btn-lg'>{{__('Back to Home')}}</a>
            </div>
            <div class="footer pt-32">
                <p class="text-center"<?php echo date("Y")?> &copy; {{ config('settings.product_name') }}</p>
            </div>
        </div>
    </body>

</html>
