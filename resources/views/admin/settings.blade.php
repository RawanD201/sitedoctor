@extends('layouts.auth')
@section('title',__('Settings'))
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

<?php $placeholder=htmlspecialchars('Example: <img src="http://yoursite.com/images/smaple.png">'); ?>
    <div class="main-content container-fluid">
        <div class="page-title d-none">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{__('Settings')}} </h3>
                    <p class="text-subtitle text-muted">{{__('Settings and API Integration')}}</p>
                </div>
            </div>
        </div>

        @if (session('settings_saved')=='1')
            <div class="alert alert-success">
                <h4 class="alert-heading">{{__('Successful')}}</h4>
                <p> {{ __('Settings have been saved successfully.') }}</p>
            </div>
        @endif


        @if ($errors->any())
            <div class="alert alert-warning">
                <h4 class="alert-heading">{{__('Something Missing')}}</h4>
                <p> {{ __('Something is missing. Please check the required inputs.') }}</p>
            </div>
        @endif

        <section class="section">
            <form  class="form form-vertical" enctype="multipart/form-data" method="POST" action="{{ route('settings.save') }}">
                @csrf

                <?php
                    $nav_items = [];
                    array_push($nav_items, ['tab'=>true,'id'=>'general-tab','href'=>'#general','title'=>__('General'),'subtitle'=>__('Brand & Preference'),'icon'=>'fas fa-cog']);
                    array_push($nav_items, ['tab'=>true,'id'=>'google-api-tab','href'=>'#google-api','title'=>__('Google API'),'subtitle'=>__('Google API Key'),'icon'=>'fas fa-plug']);
                    array_push($nav_items, ['tab'=>true,'id'=>'lead-tab','href'=>'#lead','title'=>__('lead'),'subtitle'=>__('lead settings'),'icon'=>'fas fa-users-cog']);
                    array_push($nav_items, ['tab'=>true,'id'=>'email-tab','href'=>'#email','title'=>__('email'),'subtitle'=>__('system email settings'),'icon'=>'fas fa-envelope']);
                    array_push($nav_items, ['tab'=>true,'id'=>'marketing-tab','href'=>'#marketing','title'=>__('Advertise'),'subtitle'=>__('Advertisement settings'),'icon'=>'fas fa-ad']);
                    array_push($nav_items, ['tab'=>true,'id'=>'social-tab','href'=>'#social','title'=>__('Social Media'),'subtitle'=>__('Social settings'),'icon'=>'fas fa-star']);
                    array_push($nav_items, ['tab'=>false,'id'=>'language-tab','href'=>route('languages.index'),'title'=>__('Language'),'subtitle'=>__('Multi-language Editor'),'icon'=>'fas fa-star']);

                ?>

                <div class="header-tabs d-flex align-items-stretch w-100 h-auto makescroll-no-delay mb-5 mb-lg-0" id="">
                    <ul class="nav nav-tabs nav-stretch flex-nowrap w-100 h-100" role="tablist" id="myTab">
                          @foreach($nav_items as $index=>$nav)
                            <li class="nav-item flex-equal no-radius" role="presentation">
                                <a class="nav-link d-flex flex-column text-nowrap flex-center w-100 px-2 px-lg-4 py-3 py-lg-4 text-center no-radius" href="{{$nav['href']??''}}" id="{{$nav['id']??''}}"  <?php if($nav['tab']) echo 'data-bs-toggle="tab" aria-selected="true" role="tab"'; else echo 'target="_BLANK"';?>>
                                    <span class="text-uppercase text-dark fw-bold fs-6 fs-lg-5"><i class="text-primary {{$nav['icon']??''}}"></i> {{$nav['title']}}</span>
                                    <span class="text-gray-500 fs-8 fs-lg-7 text-muted">{{$nav['subtitle']}}</span>
                                </a>
                            </li>
                          @endforeach
                    </ul>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="card">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-4 no-shadow">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Company name") }} </label>
                                                        <div class="input-group">

                                                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                            <input name="company_name" value="{{config('settings.company_name') ?? ENV('APP_NAME')}}"  class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('company_name'))
                                                            <span class="text-danger"> {{ $errors->first('company_name') }} </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Company address") }} </label>
                                                        <div class="input-group">

                                                            <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                                            <input name="company_address" value="{{config('settings.company_address') ?? old('company_address')}}"  class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('company_address'))
                                                            <span class="text-danger"> {{ $errors->first('company_address') }} </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Company Email") }} </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                            <input name="company_email" value="<?php if(config('settings.is_demo')=='1') echo '**************'; else echo config('settings.company_email') ?? old('company_email'); ?>"  class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('company_email'))
                                                            <span class="text-danger"> {{ $errors->first('company_email') }} </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Company Mobile") }} </label>
                                                        <div class="input-group">

                                                            <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                                                            <input name="company_mobile" value="<?php if(config('settings.is_demo')=='1') echo '**************'; else echo config('settings.company_mobile') ?? old('company_mobile'); ?>"  class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('company_mobile'))
                                                            <span class="text-danger"> {{ $errors->first('company_mobile') }} </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Logo") }} </label>
                                                        <?php $logo2  = ($logo != '') ? asset('storage/app/public/assets/logo/'.$logo) : asset('assets/images/logo.png');?>
                                                        <img src="{{ $logo2 }}" class="mb-2 border rounded" alt="" height="70px" width="100%">
                                                        <div class="position-relative">
                                                            <input type="file" id="logo" class="form-control" name="logo" >
                                                            @if ($errors->has('logo'))
                                                                <span class="text-danger"> {{ $errors->first('logo') }} </span>
                                                            @else
                                                                <span class="small"> 1MB, 500x150px, png/jpg/webp </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group">
                                                          <p class="m-0 text-center">
                                                            <label for="">{{ __("Favicon") }} </label><br>
                                                            <?php $favicon  = ($favicon != '') ? asset('storage/app/public/assets/favicon/'.$favicon) : asset('assets/images/favicon.png'); ?>
                                                            <img src="{{ $favicon }}" class="mb-2 border rounded text-center" alt="" height="70px">
                                                          </p>
                                                          <div class="position-relative">
                                                            <input type="file" id="favicon" class="form-control" name="favicon" >
                                                            @if ($errors->has('favicon'))
                                                                <span class="text-danger"> {{ $errors->first('favicon') }} </span>
                                                            @else
                                                                <span class="small"> 100KB, 100x100px, png/jpg/webp</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Language") }} </label>
                                                        <div class="input-group">

                                                            <span class="input-group-text"><i class="fas fa-language"></i></span>
                                                            <?php 
                                                                $default_language = config("settings.language") ?? 'en';
                                                                echo Form::select('language',$language_list,$default_language,array('class'=>'form-control'));
                                                            ?>
                                                        </div>
                                                        @if ($errors->has('language'))
                                                            <span class="text-danger"> {{ $errors->first('language') }} </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Timezone") }} </label>
                                                        <div class="input-group">

                                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                            @php
                                                                $selected = config("settings.timezone") ?? "";
                                                                if(empty($selected)) $selected = config('app.timezone');
                                                                $timezone_list = get_timezone_list();
                                                                echo Form::select('timezone',$timezone_list,$selected,array('class'=>'form-control select2'));
                                                            @endphp
                                                        </div>
                                                        @if ($errors->has('timezone'))
                                                            <span class="text-danger"> {{ $errors->first('timezone') }} </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Product Name") }} </label>
                                                        <div class="input-group">

                                                            <span class="input-group-text"><i class="fab fa-product-hunt"></i></span>
                                                            <input name="product_name" value="{{config('settings.product_name') ?? old('product_name')}}"  class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('product_name'))
                                                            <span class="text-danger"> {{ $errors->first('product_name') }} </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 d-none">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Product Version") }} </label>
                                                        <div class="input-group">

                                                            <span class="input-group-text"><i class="fas fa-code-branch"></i></span>
                                                            <input name="product_version" value="{{config('settings.product_version') ?? old('product_version')}}"  class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('product_version'))
                                                            <span class="text-danger"> {{ $errors->first('product_version') }} </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="google-api" role="tabpanel" aria-labelledby="google-api-tab">
                        <div class="card">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-header pt-5">
                                        <h4>{{__('Google API Settings')}} <span data-bs-toggle="tooltip" title="{{ __('Please enter google API key and make sure google page speed insight is enabled.') }}" class="text-primary"><i class="fas fa-info-circle"></i></span>&nbsp;&nbsp;<a class="btn btn-sm btn-primary" href="https://www.youtube.com/watch?v=4CeF1k3Sdrw" target="_BLANK"><b>{{ __("How to get google API key?") }}</b></a></h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="default_email" >{{ __('Google API Key') }} *</label>
                                            <div class="form-group">
                                                <input type="text" name="google_api_key" id="google_api_key" class="form-control" value="<?php if(config('settings.is_demo')=='1') echo '**************'; else echo config('settings.google_api_key') ?? old('google_api_key'); ?>">
                                                @if ($errors->has('google_api_key'))
                                                    <span class="text-danger"> {{ $errors->first('google_api_key') }} </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                        <div class="card">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-4 no-shadow">
                                        <div class="card-header pt-5">
                                            <h4>{{__('Email Profile')}} <a id="new-profile" href="#" class="ms-3 btn btn-outline-primary btn-sm"><i class="fas fa-plus-circle"></i> {{__('New')}}</a></h4>
                                        </div>
                                        <div class="card no-shadow">
                                            <div class="card-body data-card pt-0">
                                                <div class="table-responsive">
                                                    <table class='table table-hover table-bordered table-sm w-100' id="mytable" >
                                                        <thead>
                                                        <tr class="table-light">
                                                            <th>#</th>
                                                            <th>{{__("ID") }}</th>
                                                            <th>{{__("Email") }}</th>
                                                            <th>{{__("SMTP Host") }}</th>
                                                            <th>{{__("SMTP Port") }}</th>
                                                            <th>{{__("SMTP User") }}</th>
                                                            <th>{{__("Status") }}</th>
                                                            <th>{{__("Actions") }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="lead" role="tabpanel" aria-labelledby="lead-tab">
                        <div class="card">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-4 no-shadow">
                                        <div class="card-header pt-5">
                                            <h4>{{__('Lead Settings') }}</h4>
                                        </div>
                                        <div class="card no-shadow">
                                            <div class="card-body data-card pt-0">
                                                <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-12 col-md-6">
                                                            <label for="paypal_payment_type" >{{ __('Collect Visitor Email') }}</label>
                                                                    <span class="input-group-text pt-2 w-100 bg-white border-0">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" id="collect_visitor_email" name="collect_visitor_email" type="checkbox" value="1" @if(config("settings.collect_visitor_email")=='1') {{ 'checked' }} @else {{ '' }} @endif>
                                                                            <label class="form-check-label" for="collect_visitor_email">{{__("Yes")}}</label>
                                                                        </div>
                                                                    </span>
                                                                @if ($errors->has('collect_visitor_email'))
                                                                    <span class="text-danger"> {{ $errors->first('collect_visitor_email') }} </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{ __("Mailchimp API Key") }} </label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                                <input name="mailchimp_api_key" value="<?php if(config('settings.is_demo')=='1') echo '**************'; else echo config('settings.mailchimp_api_key') ?? old('mailchimp_api_key'); ?>"  class="form-control" type="text">
                                                            </div>
                                                            @if ($errors->has('mailchimp_api_key'))
                                                                <span class="text-danger"> {{ $errors->first('mailchimp_api_key') }} </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{ __("Mailchimp List ID") }} </label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="fas fa-bars"></i></span>
                                                                <input name="mailchimp_list_id" value="<?php if(config('settings.is_demo')=='1') echo '**************'; else echo config('settings.mailchimp_list_id') ?? old('mailchimp_list_id'); ?>"  class="form-control" type="text">
                                                            </div>
                                                            @if ($errors->has('mailchimp_list_id'))
                                                                <span class="text-danger"> {{ $errors->first('mailchimp_list_id') }} </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{ __("Report Download Limit") }} <span class="text-primary" data-bs-toggle="tooltip" title="{{ __('How many times a guest user can dowload using same email') }}"><i class="fas fa-info-circle"></i></span></label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                                <input name="report_download_limit" value="{{config('settings.report_download_limit') ?? old('report_download_limit')}}"  class="form-control" type="text">
                                                            </div>
                                                            @if ($errors->has('report_download_limit'))
                                                                <span class="text-danger"> {{ $errors->first('report_download_limit') }} </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{ __("Unlimited Download Report") }} <span class="text-primary" data-bs-toggle="tooltip" title="{{ __('Put Email addresses that can download report unlimited times') }}"><i class="fas fa-info-circle"></i></span></label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                                <input name="unlimited_report_access" value="{{config('settings.unlimited_report_access') ?? old('unlimited_report_access')}}"  class="form-control" type="text">
                                                            </div>
                                                            @if ($errors->has('unlimited_report_access'))
                                                                <span class="text-danger"> {{ $errors->first('unlimited_report_access') }} </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="marketing" role="tabpanel" aria-labelledby="marketing-tab">
                        <div class="card">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-4 no-shadow">
                                        <div class="card-header pt-5">
                                            <h4>{{__('Advertisement Settings') }}</h4>
                                        </div>
                                        <div class="card no-shadow">
                                            <div class="card-body data-card pt-0">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="paypal_payment_type" >{{ __('I want to advertise') }}</label>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-text pt-2 w-100 bg-white border-0">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" id="advertisement_status" name="advertisement_status" type="checkbox" value="1" @if(config("settings.advertisement_status")=='1') {{ 'checked' }} @else {{ '' }} @endif>
                                                                            <label class="form-check-label" for="advertisement_status">{{__("Yes")}}</label>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                                @if ($errors->has('advertisement_status'))
                                                                    <span class="text-danger"> {{ $errors->first('advertisement_status') }} </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="marketing_settings row @if(config('settings.advertisement_status')=='1') {{'d-flex'}} @else {{'d-none'}} @endif">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __("Section - 1 (970x90 px)") }} </label>
                                                                <textarea rows='2' name="section_1_wide" class="form-control" type="text" placeholder="<?php echo $placeholder;?>" >{{config('settings.section_1_wide') ?? old('section_1_wide')}}</textarea>
                                                                @if ($errors->has('section_1_wide'))
                                                                    <span class="text-danger"> {{ $errors->first('section_1_wide') }} </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __("Section - 1 : Mobile (320x100 px)") }} </label>
                                                                <textarea rows='2' name="section_1_mobile" class="form-control" type="text" placeholder="<?php echo $placeholder;?>" >{{config('settings.section_1_mobile') ?? old('section_1_mobile')}}</textarea>
                                                                @if ($errors->has('section_1_mobile'))
                                                                    <span class="text-danger"> {{ $errors->first('section_1_mobile') }} </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">{{ __("Section: 2 (300x250 px)") }} <span class="text-primary" data-bs-toggle="tooltip" title="{{ __('How many times a guest user can dowload using same email') }}"><i class="fas fa-info-circle"></i></span></label>
                                                                <textarea rows='2' name="section_2" class="form-control" type="text" placeholder="<?php echo $placeholder;?>" >{{config('settings.section_2') ?? old('section_2')}}</textarea>
                                                                @if ($errors->has('section_2'))
                                                                    <span class="text-danger"> {{ $errors->first('section_2') }} </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">{{ __("Section: 3 (300x250 px)") }} <span class="text-primary" data-bs-toggle="tooltip" title="{{ __('Put Email addresses that can download report unlimited times') }}"><i class="fas fa-info-circle"></i></span></label>
                                                                <textarea rows='2' name="section_3" class="form-control" type="text" placeholder="<?php echo $placeholder;?>" >{{config('settings.section_3') ?? old('section_3')}}</textarea>
                                                                @if ($errors->has('section_3'))
                                                                    <span class="text-danger"> {{ $errors->first('section_3') }} </span>
                                                                @endif
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">{{ __("Section: 4 (300x600 px)") }} <span class="text-primary" data-bs-toggle="tooltip" title="{{ __('Put Email addresses that can download report unlimited times') }}"><i class="fas fa-info-circle"></i></span></label>
                                                                <textarea rows='2' name="section_4" class="form-control" type="text" placeholder="<?php echo $placeholder;?>" >{{config('settings.section_4') ?? old('section_4')}}</textarea>
                                                                @if ($errors->has('section_4'))
                                                                    <span class="text-danger"> {{ $errors->first('section_4') }} </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="general-tab">
                        <div class="card">
                            <div class="row ">
                                <div class="col-11">
                                    <div class="card mb-5 no-shadow">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("facebook") }} </label>
                                                        <div class="input-group">

                                                            <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                                                            <input name="social_media_facebook" value="{{config('settings.social_media_facebook') ?? old('social_media_facebook')}}" class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('social_media_facebook'))
                                                            <span class="text-danger"> {{ $errors->first('social_media_facebook') }} </span>
                                                        @endif
                                                    </div>
                                                
                                                </div>
                                                <span class="input-group-text col-1 bg-white border-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" id="social_media_facebook_status" name="social_media_facebook_status" type="checkbox" value="1" @if(config("settings.social_media_facebook_status")=='1') {{ 'checked' }} @else {{ '' }} @endif>
                                                        <label class="form-check-label" for="social_media_facebook_status">Yes</label>
                                                    </div>
                                                </span>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("twitter") }} </label>
                                                        <div class="input-group">

                                                            <span class="input-group-text"><i class="fa-brands fa-twitter"></i></span>
                                                            <input name="social_media_twitter" value="{{config('settings.social_media_twitter') ?? old('social_media_twitter')}}"  class="form-control" type="text" >
                                                        </div>
                                                        @if ($errors->has('social_media_twitter'))
                                                            <span class="text-danger"> {{ $errors->first('social_media_twitter') }} </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <span class="input-group-text col-1 bg-white border-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" id="social_media_twitter_status" name="social_media_twitter_status" type="checkbox" value="1" @if(config("settings.social_media_twitter_status")=='1') {{ 'checked' }} @else {{ '' }} @endif>
                                                        <label class="form-check-label" for="social_media_twitter_status">Yes</label>
                                                    </div>
                                                </span>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Instagram") }} </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fa-brands fa-instagram"></i></span>
                                                            <input name="social_media_instagram" value="{{config('settings.social_media_instagram') ?? old('social_media_instagram')}}"  class="form-control" type="text" >
                                                        </div>
                                                        @if ($errors->has('social_media_instagram'))
                                                            <span class="text-danger"> {{ $errors->first('social_media_instagram') }} </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <span class="input-group-text col-1 bg-white border-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" id="social_media_instagram_status" name="social_media_instagram_status" type="checkbox" value="1" @if(config("settings.social_media_instagram_status")=='1') {{ 'checked' }} @else {{ '' }} @endif>
                                                        <label class="form-check-label" for="social_media_instagram_status">Yes</label>
                                                    </div>
                                                </span>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Linked In") }} </label>
                                                        <div class="input-group">

                                                            <span class="input-group-text"><i class="fa-brands fa-linkedin"></i></span>
                                                            <input name="social_media_linkedin" value="{{config('settings.social_media_linkedin') ?? old('social_media_linkedin')}}"  class="form-control" type="text" >
                                                        </div>
                                                        @if ($errors->has('social_media_linkedin'))
                                                            <span class="text-danger"> {{ $errors->first('social_media_linkedin') }} </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <span class="input-group-text col-1 bg-white border-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" id="social_media_linkedin_status" name="social_media_linkedin_status" type="checkbox" value="1" @if(config("settings.social_media_linkedin_status")=='1') {{ 'checked' }} @else {{ '' }} @endif>
                                                        <label class="form-check-label" for="social_media_linkedin_status">Yes</label>
                                                    </div>
                                                </span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary me-1"><i class="fas fa-save"></i> {{__('Save')}}</button>
                    </div>
                </div>
            </form>
            <div class="alert alert-warning px-4">
                <h6 class="m-0">{{__("You might need to hard refresh the page a few times to observe the changes taking effect due to browser cache.")}}</h6></div>
        </section>
    </div>

    <div class="modal fade" id="email_settings_modal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Email Profile')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <input type="hidden" id="update-id" value="0">
                   <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane active show" id="smtp-block" role="tabpanel" aria-labelledby="">
                                        <form id="smtp-block-form">
                                            <input type="hidden" name="email_table_id" id="email_table_id">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("Email Address") }} *</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fas fa-circle"></i></span>
                                                            <input name="profile_name" id="profile_name" value=""  class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('profile_name'))
                                                            <span class="text-danger"> {{ $errors->first('profile_name') }} </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("SMTP Host") }} *</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fas fa-server"></i></span>
                                                            <input name="host" id="host" value="" class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('host'))
                                                            <span class="text-danger"> {{ $errors->first('host') }} </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("SMTP User") }} *</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                            <input name="username" id="username" value=""  class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('username'))
                                                            <span class="text-danger"> {{ $errors->first('username') }} </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("SMTP Password") }} *</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                            <input name="password" id="password" value=""  class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('password'))
                                                            <span class="text-danger"> {{ $errors->first('password') }} </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("SMTP Port") }} *</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fas fa-plug"></i></span>
                                                            <input name="port" id="port" value=""  class="form-control" type="text">
                                                        </div>
                                                        @if ($errors->has('port'))
                                                            <span class="text-danger"> {{ $errors->first('port') }} </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __("SMTP Type") }} *</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fas fa-plug"></i></span>
                                                            <select name="encryption" id="encryption" class="form-control select2">
                                                                <option value="">{{ __("Select") }}</option>
                                                                <option value="Default">{{ __("Default") }}</option>
                                                                <option value="tls">{{ __("TLS") }}</option>
                                                                <option value="ssl">{{ __("SSL") }}</option>
                                                            </select>
                                                        </div>
                                                        @if ($errors->has('encryption'))
                                                            <span class="text-danger"> {{ $errors->first('encryption') }} </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="paypal_payment_type" >{{ __('Status') }}</label>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-text pt-2 w-100 bg-white">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" id="email_status" name="email_status" type="checkbox" value="1" checked>
                                                                        <label class="form-check-label" for="email_status">{{__("Active")}}</label>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                            @if ($errors->has('email_status'))
                                                                <span class="text-danger"> {{ $errors->first('email_status') }} </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>

                </div>

                <div class="modal-footer d-block">
                    <button type="button" class="btn btn-primary float-start" id="save_email_settings"><i class="fas fa-save"></i> {{__('Save')}}</button>
                    {{--<button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">{{__('Close')}}</button>--}}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts-footer')
    <script>
        "use strict";
        var is_demo = "{{ config('settings.is_demo') }}";
        var ajax_set_active_tag_id = '{{route('settings.session.tab')}}';
        var active_tag_id = '{{session('general_settings_active_tab_id')}}';
        var get_email_lists = '{{ route("settings.email.lists") }}';
    </script>
    <script src="{{ asset('assets/js/pages/settings.js') }}"></script>
@endpush
