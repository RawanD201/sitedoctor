<section id="about" class="about-section pt-0 feature-extended-section">
  <footer class="footer">
    <div class="container">
      <div class="widget-wrapper">
        <div class="row">
          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="footer-widget">
              <div class="logo mb-30">
                <a href="{{ url('') }}">
                  <img src="{{ asset('storage/app/public/assets/logo/logo.png') }}" width="300" alt="" />
                </a>
              </div>

              <address class="desc mb-30 text-white">
              <ul class="info-contact">
                  <li>
                      <span class="lnr lnr-envelope info-icon"></span>
                      <span class="info">{{ config('settings.company_name') }}</span>
                  </li>
                  <li>
                      <span class="lnr lnr-envelope info-icon"></span>
                      <span class="info">{{ config('settings.company_email') }}</span>
                  </li>
                  <li>
                      <span class="lnr lnr-map-marker info-icon"></span>
                      <span class="info">{{ config('settings.company_address') }}</span>
                  </li>
                  <li>
                      <span class="lnr lnr-phone info-icon"></span>
                      <span class="info">{{ config('settings.company_mobile') }}</span>
                  </li>
              </ul>
              </address>
              <ul class="socials">
                <?php if(config('settings.social_media_facebook_status') == '1') : ?>
                <li>
                  <a href="{{ config('settings.social_media_facebook') }}">
                    <i class="lni lni-facebook-filled"></i>
                  </a>
                </li>
                <?php endif; ?>
                <?php if(config('settings.social_media_twitter_status') == '1') : ?>
                <li>
                  <a href="{{ config('settings.social_media_twitter') }}">
                    <i class="lni lni-twitter-filled"></i>
                  </a>
                </li>
                <?php endif; ?>
                <?php if(config('settings.social_media_instagram_status') == '1') : ?>
                <li>
                  <a href="{{ config('settings.social_media_instagram') }}">
                    <i class="lni lni-instagram-filled"></i>
                  </a>
                </li>
                <?php endif; ?>
                <?php if(config('settings.social_media_linkedin_status') == '1') : ?>
                <li>
                  <a href="{{ config('settings.social_media_linkedin') }}">
                    <i class="lni lni-linkedin-original"></i>
                  </a>
                </li>
                <?php endif; ?>

              </ul>
            </div>
          </div>

          <!-- <div class="col-xl-2 col-lg-2 col-md-6">
            <div class="footer-widget">
              <h3>About Us</h3>
              <ul class="links">
                <li><a href="javascript:void(0)">Home</a></li>
                <li><a href="javascript:void(0)">Feature</a></li>
                <li><a href="javascript:void(0)">About</a></li>
                <li><a href="javascript:void(0)">Testimonials</a></li>
              </ul>
            </div>
          </div> -->

          <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="footer-widget">
              <h3>{{ __('Legal Terms') }}</h3>
              <ul class="links">
                <li><a href="{{route('privacy-policy')}}">Privacy policy</a></li>
                <li><a href="{{route('toc')}}">Terms of service</a></li>
                <li><a href="{{route('refund-policy')}}">Refund policy</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</section> <!-- end section -->