<!-- ======== preloader start ======== -->
<div class="preloader">
  <div class="loader">
    <div class="spinner">
      <div class="spinner-container">
        <div class="spinner-rotator">
          <div class="spinner-left">
            <div class="spinner-circle"></div>
          </div>
          <div class="spinner-right">
            <div class="spinner-circle"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- preloader end -->


<header class="header">
  <div class="navbar-area sticky">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-12">
          <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{ url('') }}"><img src="{{ asset('storage/app/public/assets/logo/logo.png') }}" alt="Logo"/></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="toggler-icon"></span>
              <span class="toggler-icon"></span>
              <span class="toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
              <ul id="nav" class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="page-scroll active" href="#home">{{ __("Home") }}</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#reports">{{ __("Reports") }}</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#about">{{ __("Contact") }}</a>
                </li>
                <li>
                  <a href="#" class="d-sm-none">{{ __("Sign up") }}</a>
                </li>
              </ul>
            </div>
            <!-- navbar collapse -->

            <div class="navbar-btn d-none d-sm-inline-block">
              <a class="btn btn-primary float-end text-white" href="{{route('login')}}">
                  <?php
                    if(Auth::user()) echo __('Dashboard');
                    else echo __('Sign In');
                  ?>
              </a>
            </div>
          </nav>
          <!-- navbar -->
        </div>
      </div>
      <!-- row -->
    </div>
    <!-- container -->
  </div>
  <!-- navbar area -->
</header>