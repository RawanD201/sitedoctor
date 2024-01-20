<?php 
	if($load_css_js==1) 
	{
		echo "<!DOCTYPE html><html><head>";

		$path = asset('assets/css/bootstrap.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";

		$path = asset('assets/css/pages/report/css/manual.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";

		// stisla styles
		$path = asset('assets/css/pages/report/css/style.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";

		$path = asset('assets/css/pages/report/css/component.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";

		$path = asset('assets/css/pages/report/css/custom.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";

		echo "<meta charset='UTF-8'></head><body>";
	}
	else
	{
		echo "<title>".config("settings.product_name")." | ".__("website health check")." : ".$page_title."</title>";
		echo "<meta charset='UTF-8'>";

		echo '<link rel="shortcut icon" href="'.asset('storage/app/public/assets/favicon/favicon.png').'">';
		echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700,300&amp;subset=latin,latin-ext">';
		echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:700,400,300">';
		echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">';
		echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.6/sweetalert2.css">';

		$path = asset('assets/css/bootstrap.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";

		$path = asset('assets/css/pages/report/css/report_header.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";

		$path = asset('assets/css/pages/report/css/manual.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";

		// stisla styles
		$path = asset('assets/css/pages/report/css/style.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";


		$path = asset('assets/css/pages/report/css/custom.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";


		$path = asset('assets/css/pages/report/css/component.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$data = preg_replace("#font-family:.*?;#si", "", $data);
		echo "<style>".$data."</style>";


		echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
		echo '<script src="'.asset('assets/vendors/bootstrap/js/bootstrap.min.js').'"></script>';
		echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>';
		echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.6/sweetalert2.min.js"></script>';

		echo '<script>
		    	var $j= jQuery.noConflict();
		</script>';

	}
	
	$direct_download=$direct_download;
	echo "<input type='hidden' value='".$comparision_info[0]->id."' id='hidden_id2'/>";		

	$headline=__("health report");
	$searched_at=__('examined at');

	$path = ($logo != '') ? asset('storage/app/public/assets/logo/'.$logo) : asset('assets/images/logo.png');;
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	if($load_css_js==1) {			
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		echo "<div><p align='center'><a class='d-block text-decoration-none ml-auto mr-auto text-center mt-4' href='".url('')."'><img style='max-width:200px;' src='".$base64."' alt='".config('settings.company_address')."'></a></p></div>";
		echo "<div class='text-center'><p>Powered by <a class='text-center text-decoration-none;' href='".url('')."'>".url('')."</a>"." (".config('settings.company_address').")</p></div>";
	} else {
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		echo "<div class='d-none'><br><br><a href='".url('')."'><img style='max-width:200px;' class='center-block' src='".$base64."' alt='".config('settings.company_address')."'></a></p>";			
		echo "<p class='text-center'>Powered by <a class='text-center text-decoration-none' href='".url('')."'>".url('')."</a>"." (".config('settings.company_address').") </p>";			
		echo '<div class="space"></div>';
	}
?>

<h4 id="" class="text-center"><?php echo $headline; ?> : <a href="<?php echo $site_info[0]->domain_name; ?>"  target="_BLANK"><?php echo $site_info[0]->domain_name; ?></a> Vs. <a href="<?php echo $site_info2[0]->domain_name; ?>"  target="_BLANK"><?php echo $site_info2[0]->domain_name; ?></a></h4>
<p class="text-center"> <?php echo $searched_at." : ".$comparision_info[0]->searched_at; ?></p> </div>

<link rel="stylesheet" href="{{ asset('assets/css/pages/report/css/comparison_report.css') }}">


<div class="@if($is_pdf==1) {{ 'container' }} @else {{ 'container-fluid' }} @endif boss-container">
	<?php if($load_css_js!=1) {?>
		<div class="compare_wrapper">
			<div class="profile-card js-profile-card">
				<div class="profile-card__img">
					<a href="{{ url('') }}">
						<img src="{{ ($logo != '') ? asset('storage/app/public/assets/logo/'.$logo) : asset('assets/images/logo.png'); }}" alt="profile card">
					</a>
				</div>

				<div class="profile-card__cnt js-profile-cnt">
					<h4>{{ __("Comparative Health Report") }}</h4>
					<div class="profile-card__name">{{ $page_title }}</div>
					<div class="profile-card__txt">{{ __("Powered by") }} <strong><a href='{{ url("") }}'>{{ url("") }}</a></strong></div>

					<div class="profile-card-social">
						<a href="http://www.facebook.com/sharer.php?u=<?php echo url()->current();  ?>" class="profile-card-social__item facebook" target="_blank">
							<span class="icon-font">
								<i class="fab fa-facebook-f"></i>
							</span>
						</a>

						<a href="https://twitter.com/share?url=<?php echo url()->current();  ?>" class="profile-card-social__item twitter" target="_blank">
							<span class="icon-font">
								<i class="fab fa-twitter"></i>
							</span>
						</a>

						<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo url()->current();  ?>" class="profile-card-social__item linkedin" target="_blank">
							<span class="icon-font">
								<i class="fab fa-linkedin-in"></i>
							</span>
						</a>

						<a href="http://reddit.com/submit?url=<?php echo url()->current();  ?>;title=SEO Analysis" class="profile-card-social__item reddit" target="_blank">
							<span class="icon-font">
								<i class="fab fa-reddit-alien"></i>
							</span>
						</a>

						<a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());" class="profile-card-social__item pinterest" target="_blank">
							<span class="icon-font">
								<i class="fab fa-pinterest-p"></i>
							</span>
						</a>

						<a href="http://www.tumblr.com/share/link?url=<?php echo url()->current();  ?>;title=SEO Analysis" class="profile-card-social__item tumblr" target="_blank">
							<span class="icon-font">
								<i class="fab fa-tumblr"></i>
							</span>
						</a>

						<a href="https://bufferapp.com/add?url=<?php echo url()->current();  ?>" class="profile-card-social__item bufferapp" target="_blank">
							<span class="icon-font">
								<i class="fab fa-buffer"></i>
							</span>
						</a>
						<a href="http://www.digg.com/submit?url=<?php echo url()->current();  ?>" class="profile-card-social__item digg" target="_blank">
							<span class="icon-font">
								<i class="fab fa-digg"></i>
							</span>
						</a>

						<a href="http://www.stumbleupon.com/submit?url=<?php echo url()->current();  ?>;title=SEO Analysis" class="profile-card-social__item stumble" target="_blank">
							<span class="icon-font">
								<i class="fab fa-stumbleupon"></i>
							</span>
						</a>
					</div>

					<div class="profile-card-ctr">
						<div id="compare_download_list" class="profile-card__button button--orange">{{ __("Download Pdf") }}</div>
					</div>
					
					<div class="col-12 mt-4 d-none"  id="compare_subscribe_div">
						<div class="card">							
								<h4 class="header_msg">Please provide your information, a download link will be sent to you.</h4>							
							<div class="card-body">
								<div class="d-none" id="spinner">									
									<i class="fas fa-spinner fa-spin mb-4 text-60 text-primary" ></i>
								</div>
								<div class="input-group">
									<input type="text" class="form-control" name="lead_name2" id="lead_name2" placeholder="<?php echo __('your name'); ?> *">
									<input type="email" class="form-control" name="lead_email2" id="lead_email2" placeholder="<?php echo __('your email'); ?> *">
									<button class="btn btn-primary text-white" id="send_email2">{{ __("Send Link") }}</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>


	<div class="row">
		<div class="col-12 <?php if($is_pdf==0) echo "col-md-6" ?>">
			<?php $site_info = $site_info[0]; ?>
			@include("domain.pdf_report")

		</div>
		

		<div class="col-12 <?php if($is_pdf==0) echo "col-md-6" ?>">
			<?php $site_info = $site_info2[0]; ?>
			@include("domain.pdf_report")
		</div>
	</div>
</div>


<?php if($load_css_js!=1) { ?>
	<script>
		var comparereportUri = "{{ route('domain.download.comparative.report',$comparision_info[0]->id) }}";
		var sendComparisionReportToEmail = '{{ route("domain.email.comparision.pdf") }}';
		var somethingwentwrong = '<?php echo __('something went wrong, please try again'); ?>';
		var emailsentlimitCrossed = '<?php echo __('you can not download more result using this email, download quota is crossed'); ?>';
		var emailsent ='<?php echo __('an email has been sent to your email'); ?>';
		var compare_direct_download ='<?php echo $direct_download; ?>';
		var fillRequiredfields ='{{ __("Please fill required fields") }}';
	</script>
	<script src="{{ asset('assets/js/pages/health-report/check-comparision-report.js') }}"></script>
<?php } ?>

<?php if($load_css_js==1) echo "</body></html>";?>