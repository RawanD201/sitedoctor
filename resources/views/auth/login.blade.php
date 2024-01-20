@extends('layouts.guest')
@section('title',__('Login'))
@section('content')
<div class="text-center mb-5">
    <a href="{{url('/')}}"><img src="{{ asset('storage/app/public/assets/favicon/favicon.png') }}" height="50" class='mb-4'></a>
    <h3>{{config('settings.product_name')}} - {{ __('Login') }}</h3>
</div>

<form method="POST" id="login-form" action="{{ route('login') }}">
    @csrf
    <div class="form-group position-relative has-icon-left">
        <label for="email">{{ __('Email') }}</label>
        <div class="position-relative">
            <input type="text" class="form-control" id="email" name="email" value="<?php if(config('settings.is_demo') == '1') echo 'admin@sitedoctor.com'; else echo old('email'); ?>">
            <div class="form-control-icon">
                <i data-feather="user"></i>
            </div>
        </div>
        @if ($errors->has('email'))
            <span class="text-danger">
                {{ $errors->first('email') }}
            </span>
        @endif
    </div>
    <div class="form-group position-relative has-icon-left">
        <div class="clearfix">
            <label for="password">{{ __('Password') }}</label>
        </div>
        <div class="position-relative">
            <input type="password" name="password" class="form-control" id="password" value="<?php if(config('settings.is_demo') == '1') echo '12345678'; ?>">
            <div class="form-control-icon">
                <i data-feather="lock"></i>
            </div>
        </div>
        @if ($errors->has('password'))
            <span class="text-danger">
                {{ $errors->first('password') }}
            </span>
        @endif
    </div>

    
    <div class='clearfix'>
        <div class="checkbox">
            <button id="form-submit-button" class="btn btn-lg btn-primary w-100"><i class="fas fa-user-circle"></i> {{ __('Login') }}</button>
        </div>
    </div>
    <p class="mt-3">        
        @if (Route::has('password.request'))
            <a class="float-start text-muted" href="{{ route('password.request') }}">
                <i class="fas fa-lock"></i> {{ __('Reset Password') }}
            </a>
        @endif
        {{--<a class="float-end text-dark" href="{{route('register')}}"><i class="fas fa-user-plus"></i> {{ __('Register') }}</a>--}}
    </p>
    <p>&nbsp;</p>
</form>
@endsection
