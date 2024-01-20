<link rel="stylesheet" href="{{ asset('assets/css/inlineCSS/dashboard.css') }}">

@extends('layouts.auth')
@section('title',__('Dashboard'))

@push('styles-header')
<link rel="stylesheet" href="{{ asset('assets/css/pages/dashboard.css') }}">
@endpush

@section('content')
<?php 
    $referrer_lists_colors = ['#6ab8ff','#ff8a80','#ffdf87','#c6e265','#2aedc4'];
    $progress_color_lists = ['#0d6efd','#E8A09A','#FBE29F','#C6D68F','#47B39C'];
    $badge_class = ['primary','success','warning','info','danger'];
    $pause_active = $play_active = $domain_prefix = '';
    if(isset($domain_info)) $domain_prefix = $domain_info->domain_prefix;
    if(isset($domain_info) && $domain_info->pause_play=="play") $play_active = 'active';
    else if(isset($domain_info) && $domain_info->pause_play=="pause") $pause_active = 'active';
?>

<div class="main-content container-fluid">
    <div class="page-title pb-3">
        <h3 class="d-inline me-2">{{__('Dashboard')}}</h3>
    </div>
    <section class="section">
        <div class="row">

            <div class="col-12 col-lg-4">
                <div class="card card-icon-bg-md pb-0 border-0 mb-4 " id="card" >
                    <div class="card-body bg-light-purple ps-4 pe-2" id="domain-card-body" >
                        <div class="row">
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-3">
                                        <div class="symbol-label bg-white">
                                            <i class="fas fa-globe fs-3" id="card-icon" ></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-4 text-dark fw-bold">{{count($total_site_checked)}}</div>
                                        <div class="fw-bold text-muted">{{__('Domain Checked')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card card-icon-bg-md pb-0 border-0 mb-4" id="card" >
                    <div class="card-body bg-light-purple ps-4 pe-2" id="comparative-card-body" >
                        <div class="row">
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-3">
                                        <div class="symbol-label bg-white">
                                            <i class="fas fa-compress-arrows-alt fs-3" id="card-icon" ></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-4 text-dark fw-bold">{{$total_comparative_checked}}</div>
                                        <div class="fw-bold text-muted">{{__('Comparative Check')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card card-icon-bg-md pb-0 border-0 mb-4" id="card" >
                    <div class="card-body bg-light-primary ps-4 pe-2" id="email-card-body" >
                        <div class="row">
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-3">
                                        <div class="symbol-label bg-white">
                                            <i class="fas fa-envelope text-primary fs-3" id="card-icon" ></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-4 text-dark fw-bold">{{$total_email_collected}}</div>
                                        <div class="fw-bold text-muted">{{__('Email Collected')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card no-shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <canvas id="last_seven_days_domain_traffic" height="180"></canvas>
                            </div>

                            <div class="col">
                                <div class="card mb-0 border-0">
                                    <div class="card-header py-3"><h6 class="mb-0 text-muted"><i class="fas fa-newspaper"></i> {{ __("Lastest scanned domains") }}</h6></div>
                                    <div class="card-content">
                                        <div class="card-body h-310" >
                                            @if(count($top_5_domain) > 0)

                                                <?php $maxNo = max($top_5_domain)->overall_score; ?>

                                                @php($i=0)
                                                @foreach($top_5_domain as $value)
                                                    <?php 
                                                        $width = round($value->overall_score); 
                                                        $title = $value->domain_name;
                                                        $display_title = rtrim(str_replace(array("www.","http://","https://"), "", $title),'/');
                                                    ?>
                                                <div class="d-inline">
                                                    <a data-bs-toggle="tooltip" title="{{$title}}" target="_blank" href="{{ $title }}" class="text-sm text-dark"><i class="far fa-circle" style="color: {{ $referrer_lists_colors[$i] }}"></i> {{ $display_title }}</a>
                                                </div>
                                                <div class="progress mb-3 h-14" >   
                                                    <div class="progress-bar text-dark fw-bolder" role="progressbar" style="font-size: 10px;background-color: {{ $referrer_lists_colors[$i] }};width: {{$width}}%" aria-valuenow="{{$width}}" aria-valuemin="0" aria-valuemax="100">{{$value->overall_score}}</div>
                                                </div>
                                                @php($i++)
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 mt-4">
                                <canvas id="last_30_days_emails" height="200"></canvas>                          
                            </div>

                            <div class="col">
                                <div class="card no-shadow">
                                    <div class="card-header text-muted"><h6><i class="fas fa-envelope-open-text text-muted"></i> {{ __('Latest Email Lists') }}</h6></div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            @if(count($top_5_emails) > 0)
                                            @php($i=0)
                                            @foreach($top_5_emails as $email)
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="me-auto">
                                                    <div class="mb-1"><i class="far fa-circle text-{{ $badge_class[$i] }}"></i> {{ $email->name }}</div>
                                                    <p class="mb-0 text-primary" href="">{{ $email->email }}</p>
                                                </div><span class="badge bg-{{ $i }} rounded-pill py-2 mt-2">{{ $email->no_of_search }}</span>
                                            </li>
                                            @php($i++)
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts-footer')
<script>
    "user strict";

    var last_seven_days_domains_labels = <?php echo json_encode(array_keys($last_seven_days_graph_data)); ?>;
    var last_seven_days_domains_values = <?php echo json_encode(array_values($last_seven_days_graph_data)); ?>;

    var last_30_days_emails_labels = <?php echo json_encode(array_keys($total_email)); ?>;
    var last_30_days_emails_values = <?php echo json_encode(array_values($total_email)); ?>;
    var last_30_days_download_values = <?php echo json_encode(array_values($total_download)); ?>;

    var domain_traffic_chart_step_size = <?php echo $stepSize ?>;
    var email_traffic_chart_step_size = <?php echo $stepSize2 ?>;
    var numberof_search = '{{ __("Total Scanned") }}';
    var total_emails = '{{ __("Total Email") }}';
    var seven_days_text = '{{ __("Last 7 Days Scanned Domains") }}';
    var thirty_days_text = '{{ __("Last 30 Days Collected Emails") }}';
    var total_email_text = '{{ __("Total Email") }}';
    var total_download_text = '{{ __("Total Downloads") }}';
</script>
<script src="{{ asset('assets/vendors/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush


