<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('settings.product_name') }} - @yield('title')</title>
        <link rel="shortcut icon" href="{{ asset('storage/app/public/assets/favicon/favicon.png') }}" type="image/x-icon">

        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

        @if($load_datatable)
            <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/vendors/datatables/datatables.min.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/vendors/datatables/DataTables-1.10.25/css/dataTables.bootstrap5.min.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/vendors/datatables/ColReorder-1.5.4/css/colReorder.bootstrap5.min.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/vendors/datatables/Buttons-1.7.1/css/buttons.bootstrap5.min.css') }}">
            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        @endif

        <link rel="stylesheet" href="{{ asset('assets/vendors/datetimepicker/jquery.datetimepicker.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.6/sweetalert2.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/OwlCarousel/dist/owl.carousel.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/OwlCarousel/dist/owl.theme.default.min.css') }}" />

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/summernote/summernote-bs4.css') }}" />

        <link rel="stylesheet" href="{{ asset('assets/vendors/chocolat/css/chocolat.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/prism/prism.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/css/component.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/js/common/include_head.js') }}"></script>

        @stack('styles-header')
        @stack('scripts-header')

    </head>

    <body>
        @php
            $profile_pic  = !empty(Auth::user()->profile_pic) ? Auth::user()->profile_pic : asset('assets/images/avatar/avatar-1.png');
        @endphp

        <div id="app">
            <div id="sidebar" <?php if(!in_array($route_name,$full_width_page_routes)) echo "class='active'";?>>
                <div class="sidebar-wrapper active" id="sidebaritem">
                    <div class="sidebar-header">
                        <a href="{{url('/')}}">
                            <?php
                                $site_logo = ($logo != '') ? asset('storage/app/public/assets/logo').'/'.$logo : asset('assets/images/logo.png');
                                $site_fav = ($favicon != '') ? $favicon : asset('assets/images/favicon.png');
                            ?>
                            <img src="{{ $site_logo }}" alt="" class="large-logo">
                            <img src="{{ $site_fav }}" alt="" class="small-logo">
                        </a>
                    </div>

                    <?php
                    
                        $admin_menus =  [
                            0 => ['selected' => ['general-settings'], 'href' => route('settings.index'),'icon' =>  'settings-5.png', 'title' =>  __('Settings')]
                        ];
                        $update_menus =  [
                            0 => ['selected' => ['update system'], 'href' => route('update-site-doctor'),'icon' =>  'update-3.png', 'title' =>  __('Update')]
                        ];

                        $sidebar_menu_items['main'] = [
                            'sidebar-title' =>  __('Main Menu'),
                            'sidebar-items' =>  [
                                0 => [
                                    'selected' => ['dashboard'],
                                    'href' => route('dashboard.index'),
                                    'icon' => 'dashboard.png',
                                    'title' => __('Dashboard')
                                ]
                            ],
                        ];

                        $sidebar_menu_items['report'] = [
                            'sidebar-title' => __('Health Report'),
                            'sidebar-items' => [
                                0 => [
                                    'selected' =>['site-health-report'],
                                    'href' => route('domain.site.health'),
                                    'icon' => 'dashboard2.png',
                                    'title' => __('Site Health')

                                ],
                                1 => [
                                    'selected' =>['comparative-health-report'],
                                    'href' => route('domain.comaparative.site.health'),
                                    'icon' => 'bar-chart.png',
                                    'title' => __('Comparative Health')

                                ],
                            ]
                        ];

                        $sidebar_menu_items['lead'] = [
                            'sidebar-title' =>  __('Lead'),
                            'sidebar-items' =>  [
                                0 => [
                                    'selected' => ['lead'],
                                    'href' => route('settings.lead.lists'),
                                    'icon' => 'member.png',
                                    'title' => __('Leads')
                                ]
                            ],
                        ];

                        if(!empty($admin_menus)){
                            $sidebar_menu_items['admin'] = [
                                'sidebar-title' => __('Administration'),
                                'sidebar-items' => $admin_menus
                            ];
                        }
                        if(!empty($update_menus)){
                            $sidebar_menu_items['update'] = [
                                'sidebar-title' => __('Update System'),
                                'sidebar-items' => $update_menus
                            ];
                        }

                    ?>

                    <div class="sidebar-menu" id="sidebar-menu">
                        <ul class="menu">
                            <div class="dropdown-divider m-0 pb-2"></div>

                            @foreach($sidebar_menu_items as $sec_key=>$section)
                                <?php if(empty($section)) continue; ?>
                                <li class='sidebar-title'><span>{!! $section['sidebar-title'] ?? '' !!}</span></li>
                                @foreach($section['sidebar-items'] as $menu_key=>$menu)
                                    <?php if(empty($menu)) continue; ?>
                                    <li class="sidebar-item {{ in_array($get_selected_sidebar,$menu['selected']) ? 'active' : '' }}">
                                        <a href="{{ $menu['href'] ?? '' }}" class='sidebar-link'>
                                            <?php $icon = isset($menu['icon']) ? asset('assets/images/flaticon/'.$menu['icon']) : '';?>
                                            <img src="{{$icon}}" data-bs-toggle="tooltip" data-bs-original-title="{{strip_tags($section['sidebar-title'].' : '.$menu['title'])}}" data-bs-placement="right"/>
                                            <span>{!! $menu['title'] ?? '' !!}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
                </div>
            </div>
            <div id="main">
                <nav class="navbar navbar-header navbar-expand navbar-light" id="nav">
                    <a class="sidebar-toggler pointer"><span class="navbar-toggler-icon"></span></a>
                    <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
                            <li class="dropdown nav-icon me-4">
                                <a href="#" id="notification-dropdown" data-bs-toggle="dropdown"
                                   class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                    <div class="d-lg-inline-block">
                                        <i data-feather="bell"></i><span class="badge bg-danger" id="notification-count">0</span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-large overflow-y h-max-500px"  id="notification-list">
                                    <h6 class='py-2 px-4'>{{ __('Notifications') }}</h6>
                                    <div>
                                        <ul class="list-group rounded-none">
                                                <?php
                                                   $not_link = '';
                                                ?>
                                                <div class="dropdown-divider"></div>
                                                <a href="#" class="notification-mark-seen" data-id="0">
                                                    <li class="list-group-item border-0 align-items-start py-0">
                                                        <div class="avatar me-3 align-items-center">
                                                            <span class="avatar-content"><i class=""></i></span>
                                                        </div>
                                                        <div>
                                                            <h6 class='text-bold mb-0'>Test</h6>
                                                            <p class='text-xs mb-0'>
                                                               This is test
                                                            </p>
                                                        </div>
                                                    </li>
                                                </a>
                                        </ul>
                                    </div>

                                </div>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user pe-0">
                                    <div class="avatar me-1">
                                        <img src="{{$profile_pic}}" alt="" srcset="">
                                    </div>
                                    <div class="d-none d-md-block d-lg-inline-block">{{Auth::user()->name}}</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('account') }}"><i data-feather="user"></i> {{ __('Account') }}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"><i data-feather="log-out"></i> {{ __('Logout') }}</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                @yield('content')

                <footer class="" id="footer">
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <span><?php echo date("Y")?> &copy; {{ config('settings.product_name') }}</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>


        <script src="{{ asset('assets/vendors/popper/popper.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/nicescroll/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>

        @if($load_datatable)
            <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
            <script src="{{ asset('assets/vendors/datatables/datatables.min.js') }}"></script>
            <script src="{{ asset('assets/vendors/datatables/DataTables-1.10.25/js/dataTables.bootstrap5.min.js') }}"></script>
            <script src="{{ asset('assets/vendors/datatables/ColReorder-1.5.4/js/colReorder.bootstrap5.min.js') }}"></script>
            <script src="{{ asset('assets/vendors/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js') }}"></script>
            <script src="{{ asset('assets/vendors/datatables/Buttons-1.7.1/js/buttons.bootstrap5.min.js') }}"></script>
            {{--<script src="{{ asset('assets/vendors/datatables/JSZip-2.5.0/jszip.min.js') }}"></script>--}}
            {{--<script src="{{ asset('assets/vendors/datatables/pdfmake-0.1.36/pdfmake.min.js') }}"></script>--}}
            {{--<script src="{{ asset('assets/vendors/datatables/pdfmake-0.1.36/vfs_fonts.js') }}"></script>--}}
            <script src="{{ asset('assets/vendors/datatables/Buttons-1.7.1/js/buttons.html5.min.js') }}"></script>
            {{--<script src="{{ asset('assets/vendors/datatables/Buttons-1.7.1/js/buttons.print.min.js') }}"></script>--}}
            <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        @endif

        <script src="{{ asset('assets/vendors/datetimepicker/build/jquery.datetimepicker.full.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.6/sweetalert2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="{{ asset('assets/vendors/OwlCarousel/dist/owl.carousel.min.js') }}"></script>

        <script src="{{ asset('assets/vendors/chocolat/js/jquery.chocolat.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/prism/prism.js') }}"></script>
        <script src="{{ asset('assets/vendors/summernote/summernote-bs4.js') }}"></script>

        @include('shared.variables')

        @stack('scripts-footer')
        @stack('styles-footer')

        <script src="{{ asset('assets/js/common/common.js') }}"></script>
        <script src="{{ asset('assets/js/common/include.js') }}"></script>

    </body>

</html>
