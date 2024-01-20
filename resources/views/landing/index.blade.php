@extends('layouts.site')
<?php $a = config("settings.product_name").' - '.__("Website Health Checker"); ?>
@section('title', $a )

@section("content")
  
  <!-- ======== hero-section start ======== -->
  <section id="home" class="hero-section" style="padding: 120px 0 50px !important;">
    <div class="container">
        <div class="row align-items-center position-relative">
            <div class="col-lg-6 offset-lg-3">
                <div class="hero-content text-center">
                    <h1 class="wow fadeInUp mb-3 mt-4" data-wow-delay=".4s">
                        {{ config("settings.product_name") }}
                    </h1>
                    <h2 class="text-white">{{ __("Website Health Checker") }}</h2><br/><br>

                    <p class="wow fadeInUp" data-wow-delay=".6s" style="padding-right: 0 !important;">
                        {{ __('Check the health of your site. You will receive a report at the end of test and be able to download the pdf. You will provide suggestions corresponding each issue. Try now, how it works ! This is particularly needed for site admin ।
                        example: https://example.com') }}
                    </p>
                    <br>
                    <div class="subscribe-form">
                        <input type="text" name="page_search" id="page_search" placeholder="{{ __('Put your domain here...') }}"/>
                        <button type="submit" class="main-btn btn-hover" id="search">{{__("Check")}} </button>
                    </div>

                    <div class="mt-3" id="progress_msg">
                        <b><span id="domain_progress_msg_text" style="color: white;"></span></b><br/>
                        <div class="progress" style="display: none;height: 20px;" id="domain_progress_bar_con"> 
                            <div style="width:3%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="3" role="progressbar" class="progress-bar progress-bar-striped bg-danger progress-bar-animated"><b><span>1%</span></b></div> 
                        </div>
                    </div> 
                    
                    </div>
                </div>
                <!-- <div class="col-lg-6">
                    <div class="hero-img wow fadeInUp" data-wow-delay=".5s">
                        <img src="{{ asset('assets/landing/img/hero/responsive.png') }}" alt="" />
                    </div>
                </div> -->
            </div>
        </div>
    </section>
  <!-- ======== hero-section end ======== -->

  <!-- ======== feature-section start ======== -->
  @include("landing.recent-reports")
  <!-- ======== feature-section end ======== -->

<!-- ======== feature-section start ======== -->
<section id="features" class="feature-section pt-120">
    <div class='@if(config("settings.advertisement_status")=="1") {{ "container-fluid" }} @else {{ "container" }} @endif'>

        <div class="row justify-content-center">
            <?php if(config("settings.advertisement_status")=="1") : ?>
            <div class="col-12">
                <div class="d-flex mx-5">
                    @if(config("settings.section_2")!='')
                    <div class="mb-4 flex-grow-1">{!! config("settings.section_2") !!}</div>
                    @endif
                    @if(config("settings.section_3")!='')
                    <div class="mb-4">{!! config("settings.section_3") !!}</div>
                    @endif
                </div>
            </div>
            <?php endif ?>

            <div class='@if(config("settings.advertisement_status")=="1") {{ "col-12 col-lg-9" }} @else {{ "col-12" }} @endif'>
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-sm-10">
                        <div class="single-feature">
                            <div class="icon">
                                <i class="lni lni-magnifier"></i>
                            </div>
                            <div class="content">
                                <h3>{{ __('Analyze Website') }}</h3>
                                <p class="text-left-front-page">
                                    {{ __("SiteDoctor's 'Analyze Website' feature is a powerful tool that provides a comprehensive analysis of a website's health and performance.") }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-8 col-sm-10">
                        <div class="single-feature">
                            <div class="icon">
                                <i class="lni lni-layout"></i>
                            </div>
                            <div class="content">
                                <h3>{{ __('See Report') }}</h3>
                                <p class="text-left-front-page">
                                    {{ __("SiteDoctor analysis includes checks for slow page load times, poor mobile responsiveness, missing alt tags, and more.") }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-8 col-sm-10">
                        <div class="single-feature">
                            <div class="icon">
                                <i class="lni lni-coffee-cup"></i>
                            </div>
                            <div class="content">
                                <h3>{{ __('Get Suggestion') }}</h3>
                                <p class="text-left-front-page">
                                    {{ __("SiteDoctor provides actionable insights that can help users optimize their site for better user experience and search engine optimization.") }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if(config("settings.advertisement_status")=="1") : ?>
            <div class="col-12 col-lg-3">
                    <div class="d-flex">
                        @if(config("settings.section_4")!='')
                        <div class="mb-4">{!! config("settings.section_4") !!}</div>
                        @endif
                    </div>
            </div>
            <?php endif ?>
        </div>
    </div>
</section>
<!-- ======== feature-section end ======== -->

@endsection