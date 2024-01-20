<?php if($compare_report == 0) { ?>
	<?php 	
	if($load_css_js==1) 
	{
		echo "<!DOCTYPE html><html><head>";

		$path = asset('assets/css/bootstrap.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		echo "<style>".$data."</style>";

		$path = asset('assets/css/pages/report/css/manual.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		echo "<style>".$data."</style>";

		// stisla styles
		$path = asset('assets/css/pages/report/css/style.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		echo "<style>".$data."</style>";

		$path = asset('assets/css/pages/report/css/component.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		echo "<style>".$data."</style>";

		$path = asset('assets/css/pages/report/css/custom.css');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		echo "<style>".$data."</style>";

		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head><body style='font-family: DejaVu Sans, sans-serif !important;'>";
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
	
	echo "<input type='hidden' value='".$site_info->id."' id='hidden_id'/>";		


	$headline=__("health report");
	$catch_line=__('follow recommendations of this health report to keep your site healthy');
	$searched_at=__('examined at');

	$path = ($logo != '') ? asset('storage/app/public/assets/logo/'.$logo) : asset('assets/images/logo.png');
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);

	if($load_css_js==1) {
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		echo "<div><p align='center'><a class='d-block ml-auto mr-auto text-center mt-4' href='".url("")."'><img style='max-width:200px;' src='".$base64."' alt='".config("settings.comapny_address")."'></a></p>";
	}
	else {
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		echo "<div class='starter d-none'><a href='".url('')."'><img style='max-width:200px;' class='center-block' src='".$base64."' alt='".config("settings.comapny_address")."'></a></p>";			
		echo "<p align='center'>Powered by <a style='text-align:center;text-decoration:none;' href='".url('')."'>".url('')."</a>"." (".config("settings.comapny_address").")"."</p>";
	}
?>

		<h4 id="" class="text-center"><?php echo $headline; ?> : <a class='text-decoration-none text-14' href="<?php echo $site_info->domain_name; ?>" target="_BLANK"><?php echo $site_info->domain_name; ?></a></h4>
		<p class="text-center"><?php echo "<b>".$searched_at."</b> : ".date("y-m-d H:i:s", strtotime($site_info->searched_at)); ?></p>
		<p class="text-center"><?php echo $catch_line; ?></p>
	</div>

<?php 
} 

   $desktop_lighthouseresult_categories = json_decode($site_info->desktop_lighthouseresult_categories,true) ?? [];
   $desktop_lighthouseresult_configsettings = json_decode($site_info->desktop_lighthouseresult_configsettings,true) ?? [];
   $desktop_loadingexperience_metrics = json_decode($site_info->desktop_loadingexperience_metrics,true) ?? [];					   	
   $desktop_originloadingexperience_metrics = json_decode($site_info->desktop_originloadingexperience_metrics,true) ?? [];	
   $desktop_lighthouseresult_audits = json_decode($site_info->desktop_lighthouseresult_audits,true) ?? [];
   $first_meaningful_paint_desktop = isset($desktop_lighthouseresult_audits['first-meaningful-paint']['score']) ? $desktop_lighthouseresult_audits['first-meaningful-paint']['score'] : 0;
   $speed_index_desktop = isset($desktop_lighthouseresult_audits['speed-index']['score']) ? $desktop_lighthouseresult_audits['speed-index']['score'] : 0;
   $first_cpu_idle_desktop = isset($desktop_lighthouseresult_audits['first-cpu-idle']['score']) ? $desktop_lighthouseresult_audits['first-cpu-idle']['score'] : 0;
   $first_contentful_paint_desktop = isset($desktop_lighthouseresult_audits['first-contentful-paint']['score']) ? $desktop_lighthouseresult_audits['first-contentful-paint']['score'] : 0;
   $interactive_desktop = isset($desktop_lighthouseresult_audits['interactive']['score']) ? $desktop_lighthouseresult_audits['interactive']['score'] : 0;
   $desktop_score = ($first_meaningful_paint_desktop*7)+($speed_index_desktop*27)+($first_cpu_idle_desktop*13)+($first_contentful_paint_desktop*20)+($interactive_desktop*33);  


   $mobile_lighthouseresult_categories = json_decode($site_info->mobile_lighthouseresult_categories,true) ?? [];
   $mobile_lighthouseresult_configsettings = json_decode($site_info->mobile_lighthouseresult_configsettings,true) ?? [];
   $mobile_loadingexperience_metrics = json_decode($site_info->mobile_loadingexperience_metrics,true) ?? [];					   	
   $mobile_originloadingexperience_metrics = json_decode($site_info->mobile_originloadingexperience_metrics,true) ?? [];	
   $mobile_lighthouseresult_audits = json_decode($site_info->mobile_lighthouseresult_audits,true) ?? [];
   $first_meaningful_paint_mobile = isset($mobile_lighthouseresult_audits['first-meaningful-paint']['score']) ? $mobile_lighthouseresult_audits['first-meaningful-paint']['score'] : 0;
   $speed_index_mobile = isset($mobile_lighthouseresult_audits['speed-index']['score']) ? $mobile_lighthouseresult_audits['speed-index']['score'] : 0;
   $first_cpu_idle_mobile = isset($mobile_lighthouseresult_audits['first-cpu-idle']['score']) ? $mobile_lighthouseresult_audits['first-cpu-idle']['score'] : 0;
   $first_contentful_paint_mobile = isset($mobile_lighthouseresult_audits['first-contentful-paint']['score']) ? $mobile_lighthouseresult_audits['first-contentful-paint']['score'] : 0;
   $interactive_mobile = isset($mobile_lighthouseresult_audits['interactive']['score']) ? $mobile_lighthouseresult_audits['interactive']['score'] : 0;
   $mobile_score = ($first_meaningful_paint_mobile*7)+($speed_index_mobile*27)+($first_cpu_idle_mobile*13)+($first_contentful_paint_mobile*20)+($interactive_mobile*33);  		

   $share_current_url = url()->current();			   						   
?>

<?php if($compare_report==0 && $load_css_js!=1): ?>
	<div class="wrapper">
		<div class="profile-card js-profile-card">
			<div class="profile-card__img">
				<a href="{{ url('') }}">
					<img src="{{ ($logo != '') ? asset('storage/app/public/assets/logo/'.$logo) : asset('assets/images/logo.png'); }}" alt="profile card">
				</a>
			</div>

			<div class="profile-card__cnt js-profile-cnt">
				<div class="profile-card__name">{{ $site_info->domain_name }}</div>
				<div class="profile-card__txt">{{ __("Website Health Report powered by") }} <strong><a href='{{ url("") }}'>{{ url("") }}</a></strong></div>
				<div class="profile-card-loc">
					<span class="profile-card-loc__icon">
						<i class="fas fa-clock text-18 text muted" ></i>&nbsp;
						{{-- style="font-size: 18px;color: #7b7777;" --}}
					</span>

					<span class="profile-card-loc__txt">{{ date("M j, Y H:i:s", strtotime($site_info->searched_at)) }}</span>
				</div>

				<div class="profile-card-inf">
					<div class="profile-card-inf__item">
						<div class="profile-card-inf__title">{{ $site_info->overall_score }} <sub>/ 100</sub></div>
						<div class="profile-card-inf__txt">{{ __("Overall Score") }}</div>
					</div>

					<div class="profile-card-inf__item">
						<div class="profile-card-inf__title">{{ $desktop_score }} <sub>/ 100</sub></div>
						<div class="profile-card-inf__txt">{{ __("Desktop Score") }}</div>
					</div>

					<div class="profile-card-inf__item">
						<div class="profile-card-inf__title">{{ $mobile_score }} <sub>/ 100</sub></div>
						<div class="profile-card-inf__txt">{{ __("Mobile Score") }}</div>
					</div>
				</div>

				<div class="profile-card-social">
					<a href="http://www.facebook.com/sharer.php?u=<?php echo $share_current_url;  ?>" class="profile-card-social__item facebook" target="_blank">
						<span class="icon-font">
							<i class="fab fa-facebook-f"></i>
						</span>
					</a>

					<a href="https://twitter.com/share?url=<?php echo $share_current_url;  ?>" class="profile-card-social__item twitter" target="_blank">
						<span class="icon-font">
							<i class="fab fa-twitter"></i>
						</span>
					</a>

					<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $share_current_url;  ?>" class="profile-card-social__item linkedin" target="_blank">
						<span class="icon-font">
							<i class="fab fa-linkedin-in"></i>
						</span>
					</a>

					<a href="http://reddit.com/submit?url=<?php echo $share_current_url;  ?>;title=SEO Analysis" class="profile-card-social__item reddit" target="_blank">
						<span class="icon-font">
							<i class="fab fa-reddit-alien"></i>
						</span>
					</a>

					<a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());" class="profile-card-social__item pinterest" target="_blank">
						<span class="icon-font">
							<i class="fab fa-pinterest-p"></i>
						</span>
					</a>

					<a href="http://www.tumblr.com/share/link?url=<?php echo $share_current_url;  ?>;title=SEO Analysis" class="profile-card-social__item tumblr" target="_blank">
						<span class="icon-font">
							<i class="fab fa-tumblr"></i>
						</span>
					</a>

					<a href="https://bufferapp.com/add?url=<?php echo $share_current_url;  ?>" class="profile-card-social__item bufferapp" target="_blank">
						<span class="icon-font">
							<i class="fab fa-buffer"></i>
						</span>
					</a>
					<a href="http://www.digg.com/submit?url=<?php echo $share_current_url;  ?>" class="profile-card-social__item digg" target="_blank">
						<span class="icon-font">
							<i class="fab fa-digg"></i>
						</span>
					</a>

					<a href="http://www.stumbleupon.com/submit?url=<?php echo $share_current_url;  ?>;title=SEO Analysis" class="profile-card-social__item stumble" target="_blank">
						<span class="icon-font">
							<i class="fab fa-stumbleupon"></i>
						</span>
					</a>
				</div>
				
				<?php if($compare_report == 0) : ?>
				<div class="subscribe-form d-none">
		            <input type="text" name="page_search" id="page_search" placeholder="{{ __('Put your domain here...') }}">
		            <button type="submit" class="main-btn btn-hover" id="search">{{ __("Compare") }}</button>
	            </div>
	        	<?php endif; ?>

				<div class="profile-card-ctr">
					<div class="profile-card__button button--blue compare_website">{{ __("Compare") }}</div>
					<div id="download_list" class="profile-card__button button--orange">{{ __("Download Pdf") }}</div>
				</div>

				<div class="col-12 mt-4 d-none"  id="subscribe_div">
					<div class="card border shadow-0">
						<div class="card-header border-bottom">
							<h4>{{ __("Lead Info") }}</h4>
						</div>
						<div class="card-body">
							<div id="spinner" class="d-none;">
								<i class="fas fa-spinner fa-spin text-60 mb-4 text-primary text-60"></i>
							</div>
							<div class="input-group">
								<input type="text" class="form-control" name="lead_name" id="lead_name" placeholder="<?php echo __('your name'); ?> *">
								<input type="email" class="form-control" name="lead_email" id="lead_email" placeholder="<?php echo __('your email'); ?> *">
								<button class="btn btn-primary text-white" id="send_email">{{ __("Send Link") }}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php 		
	$warning_count=$site_info->warning_count;
	$warning_class="success";
	$pdf_card="";
	if($warning_count>0) $warning_class="warning";
	if($is_pdf==1) $pdf_card = 'pdf_card';
?>
<link rel="stylesheet" href="{{ asset('assets/css/inlineCSS/pdf-report.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/pages/report/css/download_pdf_report.css') }}">

<?php if($is_pdf == 1) : ?>
<link rel="stylesheet" href="{{ asset('assets/css/pages/report/css/single_pdf_report.css') }}">
<?php endif; ?>
	

<?php if($is_pdf == 0) : ?>
<link rel="stylesheet" href="{{ asset('assets/css/inlineCSS/pdf-report.css') }}">
<?php endif; ?>    

<div class="<?php if($compare_report == 0) echo "container"; else echo "container-fluid"; ?>">
	<section class="section mt-3">
		<div class="row">
			<div class="col-12">
				<?php if($load_css_js!=1) {?>

					<?php if($compare_report == 1) { ?>
						<div class="alert alert-light alert-has-icon mt-3 mb-5">
							<div class="alert-icon"><i class="far fa-lightbulb"></i></div>
							<div class="alert-body">
								<div class="alert-title"><?php echo __('Domain Name'); ?></div>
								<a class="font-weight-bold" href="<?php echo $site_info->domain_name; ?>"><?php echo $site_info->domain_name; ?></a>
							</div>
						</div>
					
						<div class="card card-primary is_pdf">
							<div class="card-header">
								<h4><i class="fas fa-star-half-alt"></i> <?php echo __('Score'); ?></h4>
								<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
							</div>
							<div class="card-body chart-responsive minus">
								<div class="progress score_card">
								  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $site_info->overall_score; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $site_info->overall_score; ?>%"><?php echo $site_info->overall_score; ?></div>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } else { ?>
					<?php if($compare_report == 1) { ?>
						<div class="alert alert-light alert-has-icon mt-3 mb-5">
							<div class="alert-icon"><i class="far fa-lightbulb"></i></div>
							<div class="alert-body">
								<div class="alert-title"><?php echo __('Domain Name'); ?></div>
								<a class="font-weight-bold" href="<?php echo $site_info->domain_name; ?>"><?php echo $site_info->domain_name; ?></a>
							</div>
						</div>
					<?php } ?>

					<div class="card card-primary">
						<div class="card-header">
							<h4><i class="fas fa-star-half-alt"></i> <?php echo __('Score'); ?></h4>
							<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
						</div>
						<div class="card-body chart-responsive minus">
							<div class="progress score_card">
							  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $site_info->overall_score; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $site_info->overall_score; ?>%"><?php echo $site_info->overall_score; ?></div>
							</div>
						</div>
					</div>
				<?php } ?>

				<!-- page title start-->
				<?php 
				$recommendation_word = __("Knowledge Base");
				$value = $site_info->title;
				$check = title_check($value); 
				$item = __("Page Title");
				$long_recommendation=$recommendations['page_title_recommendation'];
				if(strlen($value)==0)
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Your site do not have any title.");
				}
				else if($check=="1")
				{
					$class="warning";
					$status="exclamation-circle";
					$short_recommendation=__("Your page title exceeds 60 characters. It's not good.");
				}
				else
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Your page title does not exceed 60 characters. It's fine.");
				}
				?>

				<!-- page title start -->
				<div class="card card-<?php echo $class; ?> is_pdf">
					<div class="card-header bbw">
						<h4 class="text-<?php echo $class; ?> mt-0"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>
					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 610px; overflow-y:auto;"'; ?>>
						<div class="section-title mt-0 item-header"><?php echo $item; ?></div>
						<p class="section-lead item-value"><?php echo $value; ?></p>

						<div class="section-title mt-0 item-header"><?php echo __("Short Recommendation"); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>
						
						<?php if($is_pdf != 1) : ?>
							<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>">
								<?php echo $recommendation_word; ?></div>
							<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div> 
				<!--  page title end-->
			</div>
		</div>

		<!-- meta description start-->				
		<div class="row">
			<div class="col-12">
				<?php 
					$value = $site_info->description;
					$check = description_check($value); 
					$item = __("Meta Description");
					$long_recommendation = __('description_recommendation');
					if(strlen($value)==0) // error
					{
						$class="danger";
						$status="times";
						$short_recommendation=__("Your site do not have any meta description.");
					}
					else if($check=="1") //warning
					{
						$class="warning";
						$status="exclamation-circle";
						$short_recommendation=__("Your meta description exceeds 150 characters. It's not good.");
					}
					else // ok
					{
						$class="success";
						$status="check";
						$short_recommendation=__("Your meta description does not exceed 150 characters. It's fine.");
					}
				?>

				<div class="card card-<?php echo $class; ?> is_pdf">
					<div class="card-header bbw">
						<h4 class="text-<?php echo $class; ?> mt-0"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i>
						</div>
					</div>
					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 600px; overflow-y:auto;"'?>>
						<div class="section-title mt-0 item-header"><?php echo $item; ?></div>
						<p class="section-lead item-value"><?php echo $value; ?></p>

						<div class="section-title mt-0 item-header"><?php echo __("Short Recommendation"); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>
						
						<?php if($is_pdf != 1) : ?>
							<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>">
								<?php echo $recommendation_word; ?></div>
							<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>
						
					</div>
				</div>
			</div>
		</div>
		<!-- meta description end-->

		<!-- meta keyword start-->
		<div class="row">
			<div class="col-12">
				<?php 
				$value=$site_info->meta_keyword;
				$check=empty($value) ? 1 : 0;
				$item=__("Meta Keyword");
				$long_recommendation=$recommendations['meta_keyword_recommendation'];
				if($check=="1") //error
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Your site do not have any meta keyword.");
				}
				else //ok
				{
					$class="success";
					$status="check";
					$short_recommendation="";
				}
				?> 

				<div class="card card-<?php echo $class; ?> is_pdf">
					<div class="card-header bbw">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>
					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height:400px; overflow-y:auto;"'?>>
						<div class="section-title mt-0 item-header"><?php echo $item; ?></div>
						<p class="section-lead item-value"><?php echo $value; ?></p>

						<div class="section-title mt-0 item-header"><?php echo __("Short Recommendation"); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>
						
						<?php if($is_pdf != 1) : ?>
							<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>">
								<?php echo $recommendation_word; ?></div>
							<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>
						
					</div>
				</div>
			</div>
		</div>
		<!--  meta keyword end-->

		<div class="row">
			<?php 
				$one_phrase = json_decode($site_info->keyword_one_phrase,true); 
				$two_phrase = json_decode($site_info->keyword_two_phrase,true); 
				$three_phrase = json_decode($site_info->keyword_three_phrase,true); 
				$four_phrase = json_decode($site_info->keyword_four_phrase,true); 
				$total_words = empty($site_info->total_words) ? 0 : $site_info->total_words;
				// include("application/modules/sitedoctor/views/array_spam_keyword.php");
				$array_spam_keyword = $spam_keywords;
			
				$class="primary";
				$status="info-circle";
			?>

			<div class="col-12">
				<div class="card card-<?php echo $class; ?> is_pdf">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-info-circle"></i> <?php echo __('Keyword Analysis'); ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus row" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 1670px; overflow-y:auto;";' ?>>
						<div class="col-12 col-sm-12 <?php if($compare_report == 0) echo "col-md-6 col-lg-6"; ?>">
							<div class="card card-<?php echo $class; ?>">
								<div class="card-header bg-<?php if($is_pdf==0) echo $class; else echo ""; ?>">
									<h4 class="<?php if($is_pdf==0) echo 'text-white'; else echo "text-dark"; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo __("Single Keywords"); ?></h4>
									<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
								</div>

								<div class="card-body chart-responsive minus p-0">
									<div class="table-resposive table-responsive-vertical">
										<table class="table table-sm table-bordered table-hover text-center">
											<thead>
												<tr>
													<th><?php echo __("Keyword"); ?></th>
													<th><?php echo __("Occurrence"); ?></th>
													<th><?php echo __("Density"); ?></th>
													<th><?php echo __("Possible Spam"); ?></th>
												</tr>
											</thead>
											
											<tbody>
												<?php foreach ($one_phrase as $key => $value) : ?>
													<tr>
														<td><?php echo $key; ?></td>
														<td><?php echo $value; ?></td>
														<td><?php $occurence = ($value/$total_words)*100; echo round($occurence, 3)." %"; ?></td>
														<td><?php 
																if(in_array(strtolower($key), $array_spam_keyword)) echo "Yes";
																else echo 'No'; 
															?>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 col-sm-12 <?php if($compare_report == 0) echo "col-md-6 col-lg-6"; ?>">
							<div class="card card-<?php echo $class; ?>">
								<div class="card-header bg-<?php if($is_pdf==0) echo $class; else echo ""; ?>">
									<h4 class="<?php if($is_pdf==0) echo 'text-white'; else echo "text-dark"; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo __("Two Word Keywords"); ?></h4>
									<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
								</div>

								<div class="card-body chart-responsive minus p-0">
									<div class="table-resposive table-responsive-vertical">
										<table class="table table-sm table-bordered table-hover text-center">
											<thead>
												<tr>
													<th><?php echo __("Keyword"); ?></th>
													<th><?php echo __("Occurrence"); ?></th>
													<th><?php echo __("Density"); ?></th>
													<th><?php echo __("Possible Spam"); ?></th>
												</tr>
											</thead>
											
											<tbody>
												<?php foreach ($two_phrase as $key => $value) : ?>
													<tr>
														<td><?php echo $key; ?></td>
														<td><?php echo $value; ?></td>
														<td><?php $occurence = $value/$total_words*100; echo round($occurence, 3)." %"; ?></td>
														<td><?php 
																if(in_array(strtolower($key), $array_spam_keyword)) echo "Yes";
																else echo 'No'; 
															?>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 col-sm-12 <?php if($compare_report == 0) echo "col-md-6 col-lg-6"; ?>">
							<div class="card card-<?php echo $class; ?>">
								<div class="card-header bg-<?php if($is_pdf==0) echo $class; else echo ""; ?>">
									<h4 class="<?php if($is_pdf==0) echo 'text-white'; else echo "text-dark"; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo __("Three Word Keywords"); ?></h4>
									<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
								</div>

								<div class="card-body chart-responsive minus p-0">
									<div class="table-resposive table-responsive-vertical">
										<table class="table table-sm table-bordered table-hover text-center">
											<thead>
												<tr>
													<th><?php echo __("Keyword"); ?></th>
													<th><?php echo __("Occurrence"); ?></th>
													<th><?php echo __("Density"); ?></th>
													<th><?php echo __("Possible Spam"); ?></th>
												</tr>
											</thead>
											
											<tbody>
												<?php foreach ($three_phrase as $key => $value) : ?>
													<tr>
														<td><?php echo $key; ?></td>
														<td><?php echo $value; ?></td>
														<td><?php $occurence = $value/$total_words*100; echo round($occurence, 3)." %"; ?></td>
														<td><?php 
																if(in_array(strtolower($key), $array_spam_keyword)) echo "Yes";
																else echo 'No'; 
															?>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 col-sm-12 <?php if($compare_report == 0) echo "col-md-6 col-lg-6"; ?>">
							<div class="card card-<?php echo $class; ?>">
								<div class="card-header bg-<?php if($is_pdf==0) echo $class; else echo ""; ?>">
									<h4 class="<?php if($is_pdf==0) echo 'text-white'; else echo "text-dark"; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo __("Four Word Keywords"); ?></h4>
									<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
								</div>

								<div class="card-body chart-responsive minus p-0">
									<div class="table-resposive table-responsive-vertical">
										<table class="table table-sm table-bordered table-hover text-center">
											<thead>
												<tr>
													<th><?php echo __("Keyword"); ?></th>
													<th><?php echo __("Occurrence"); ?></th>
													<th><?php echo __("Density"); ?></th>
													<th><?php echo __("Possible Spam"); ?></th>
												</tr>
											</thead>
											
											<tbody>
												<?php foreach ($four_phrase as $key => $value) : ?>
													<tr>
														<td><?php echo $key; ?></td>
														<td><?php echo $value; ?></td>
														<td><?php $occurence = $value/$total_words*100; echo round($occurence, 3)." %"; ?></td>
														<td><?php 
																if(in_array(strtolower($key), $array_spam_keyword)) echo "Yes";
																else echo 'No'; 
															?>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- end of 1,2,3,4 keyword -->

		<!-- Key words usage start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$value = $site_info->meta_keyword;
				$check = keyword_usage_check($site_info->meta_keyword,array_keys($one_phrase),array_keys($two_phrase),array_keys($three_phrase),array_keys($four_phrase));
				$item = __("Keyword Usage");
				$long_recommendation=$recommendations['keyword_usage_recommendation'];
				if($check=="1") //error
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("The most using keywords do not match with meta keywords.");
				}
				else //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("The most using keywords match with meta keywords.");
				}
				?>

				<div class="card card-<?php echo $class; ?> is_pdf">
					<div class="card-header bbw">
						<h4 class="text-<?php echo $class; ?> mt-0"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i>
						</div>
					</div>
					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 400px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo $item; ?></div>
						<p class="section-lead item-value"><?php echo $value; ?></p>

						<div class="section-title mt-0 item-header"><?php echo __("Short Recommendation"); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>
						
						<?php if($is_pdf != 1) : ?>
							<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>">
								<?php echo $recommendation_word; ?></div>
							<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>
						
					</div>
				</div>
			</div>
		</div>
		<!--  Key words usage end-->

		<!--total words start-->
		<div class="row">
			<div class="col-12">				
				<?php 
					$value=$site_info->total_words;
					$item=__("Total Words");
					$long_recommendation=$recommendations['unique_stop_words_recommendation'];
					$class="primary";
					$status="info-circle";
				
				?>

				<div class="card card-<?php echo $class; ?> is_pdf">
					<div class="card-header bbw">
						<h4 class="text-<?php echo $class; ?> mt-0" ><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i>
						</div>
					</div>
					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 460px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo $item; ?></div>
						<p class="section-lead item-value"><?php echo $value; ?></p>
						
						<?php if($is_pdf != 1) : ?>
							<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>">
								<?php echo $recommendation_word; ?></div>
							<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>
						
					</div>
				</div>
			</div>
		</div>
		<!--total words end-->

		<!-- text_to_html_ratiostart-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$check=round($site_info->text_to_html_ratio); 
				$item=__("Text/HTML Ratio Test");
				$long_recommendation=$recommendations['text_to_html_ratio_recommendation'];

				if($check<20) //error
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Site failed text/HTML ratio test.");
				}
				else //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Site passed text/HTML ratio test.");
				}
				// $short_recommendation.="<br/><br/><i class='fa fa-".$status."'></i> <b>".$item." : ".$check."%</b>";
				?>
				
				<div class="card card-<?php echo $class; ?> is_pdf">
					<div class="card-header bbw">
						<h4 class="text-<?php echo $class; ?> mt-0" ><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i>
						</div>
					</div>
					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 300px; overflow-y:auto;"';?>>

						<div class="section-title mt-0 item-header"><?php echo $short_recommendation; ?></div>
						<p class="section-lead item-value"><?php echo $item.' : '.$check."% "; ?></p>
						
						<?php if($is_pdf != 1) : ?>
							<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>">
								<?php echo $recommendation_word; ?></div>
							<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>
						
					</div>
				</div>
			</div>
		</div>
		<!--text_to_html_ratio end-->

		<!-- html headings -->
		<div class="row">
			<?php 
				$h1=json_decode($site_info->h1,true); 
				$h2=json_decode($site_info->h2,true); 
				$h3=json_decode($site_info->h3,true); 
				$h4=json_decode($site_info->h4,true); 
				$h5=json_decode($site_info->h5,true); 
				$h6=json_decode($site_info->h6,true); 			
			?>
			<?php 
				$item=__("HTML Headings");
				$long_recommendation=$recommendations['heading_recommendation'];
				$class="primary";
				$status="info-circle";
			?>
			<div class="col-12">
				<div class="card card-<?php echo $class;?> is_pdf">
					<div class="card-header">
						<h4 class="text-<?php echo $class;?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action">
							<i class="fa fa-minus minus"></i>
						</div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 980px; overflow-y:auto;"';?>>
						<div class="row">
							<div class="col-12 pb-5 <?php if($compare_report == 0) echo "col-sm-6 col-md-4 col-lg-4"; else echo "col-sm-6 col-md-6 col-lg-6"; ?>">
								<ul class="list-group pdf-heading">
									<li class="list-group-item active text-center">H1(<?php echo count($h1) ?>)</li>  
									<div class="heading_styles">
										<?php foreach($h1 as $key=>$value): ?>
											<li class="list-group-item"><?php echo $value; ?></li>
										<?php endforeach; ?>
									</div>
								</ul>
							</div>
							<div class="col-12 pb-5 <?php if($compare_report == 0) echo "col-sm-6 col-md-4 col-lg-4"; else echo "col-sm-6 col-md-6 col-lg-6"; ?>">
								<ul class="list-group pdf-heading">
									<li class="list-group-item active text-center">H2(<?php echo count($h2) ?>)</li>  
									<div class="heading_styles">
										<?php foreach($h2 as $key=>$value): ?>
											<li class="list-group-item"><?php echo $value; ?></li>
										<?php endforeach; ?>
									</div>
								</ul>
							</div>
							<div class="col-12 pb-5 <?php if($compare_report == 0) echo "col-sm-6 col-md-4 col-lg-4"; else echo "col-sm-6 col-md-6 col-lg-6"; ?>">
								<ul class="list-group pdf-heading">
									<li class="list-group-item active text-center">H3(<?php echo count($h3) ?>)</li>  
									<div class="heading_styles">
										<?php foreach($h3 as $key=>$value): ?>
											<li class="list-group-item"><?php echo $value; ?></li>
										<?php endforeach; ?>
									</div>
								</ul>
							</div>

							<div class="col-12 pb-5 <?php if($compare_report == 0) echo "col-sm-6 col-md-4 col-lg-4"; else echo "col-sm-6 col-md-6 col-lg-6"; ?>">
								<ul class="list-group pdf-heading">
									<li class="list-group-item active text-center bold">H4(<?php echo count($h4) ?>)</li>  
									<div class="heading_styles">
										<?php foreach($h4 as $key=>$value): ?>
											<li class="list-group-item"><?php echo $value; ?></li>
										<?php endforeach; ?>
									</div>
								</ul>
							</div>
							<div class="col-12 pb-5 <?php if($compare_report == 0) echo "col-sm-6 col-md-4 col-lg-4"; else echo "col-sm-6 col-md-6 col-lg-6"; ?>">
								<ul class="list-group pdf-heading">
									<li class="list-group-item active text-center bold">H5(<?php echo count($h5) ?>)</li>  
									<div class="heading_styles">
										<?php foreach($h5 as $key=>$value): ?>
											<li class="list-group-item"><?php echo $value; ?></li>
										<?php endforeach; ?>
									</div>
								</ul>
							</div>
							<div class="col-12 pb-5 <?php if($compare_report == 0) echo "col-sm-6 col-md-4 col-lg-4"; else echo "col-sm-6 col-md-6 col-lg-6"; ?>">
								<ul class="list-group pdf-heading">
									<li class="list-group-item active text-center bold">H6(<?php echo count($h6) ?>)</li>  
									<div class="heading_styles">
										<?php foreach($h6 as $key=>$value): ?>
											<li class="list-group-item"><?php echo $value; ?></li>
										<?php endforeach; ?>
									</div>
								</ul>
							</div>
						</div>
						<br>
						
						<?php if($is_pdf != 1) : ?>
						<div class="row">
							<div class="col-12">
								<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
								<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
							</div>
						</div>
						<?php endif; ?>

					</div>
				</div>
			</div>		
		</div>
		<!-- html headings -->

		<!-- robot start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$value=$site_info->robot_txt_exist;
				$check=$value;
				$item=__("robot.txt");
				$long_recommendation=$recommendations['robot_recommendation'];
				if($check=="0") //warning
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Your site does not have robot.txt.");
				}
				else //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Your site have robot.txt");
				}
				?>
				<div class="card card-<?php echo $class; ?> is_pdf">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 900px; overflow-y:auto;"';?>>
						<div class="section-title mt-0"><?php echo __("Short Recommendation"); ?></div>
						<p class="section-lead"><?php echo $short_recommendation; ?></p>

						<div class="row">
							<div class="col-12">
								<?php if($check == "1" && $is_pdf != 1) { ?>
									<ul class="list-group generic-ul pdf-heading">
										<li class="list-group-item active text-center"><?php echo $item; ?></li>  
										<div class="heading_styles">
											<li class="list-group-item border-bottom">
												<?php print_r($site_info->robot_txt_content);?>
											</li>
										</div>
									</ul>
								<?php } ?>

								<?php if($is_pdf != 1) : ?>
								<br/><br/>
								<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
								<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
								<?php endif; ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--  robot end-->
	
		<!-- sitemap start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$value=$site_info->sitemap_exist;
				$check=$value;
				$item=__("Sitemap");
				$long_recommendation=$recommendations['sitemap_recommendation'];
				if($check=="0") //warning
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Your site does not have sitemap");
				}
				else //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Your site have sitemap");
				}
				?>
				
				<div class="card card-<?php echo $class; ?> is_pdf">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 1060px; overflow-y:auto;"';?>>
						<div class="section-title mt-0"><?php echo __("Short Recommendation"); ?></div>
						<p class="section-lead"><?php echo $short_recommendation; ?></p>

						<?php if($check == "1") { ?>
							<div class="section-title mt-0 item-header"><?php echo __("Location"); ?></div>
							<p class="section-lead item-value">
								<a target='_BLANK' href="<?php echo $site_info->sitemap_location; ?>"><?php echo $site_info->sitemap_location; ?></a>
							</p>
						<?php } ?>

						<?php if($is_pdf != 1) : ?>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--  sitemap end-->

		<!-- Internal Vs. External Links start-->
		<!-- <div class="row"> -->
			<!-- <div class="col-12">				 -->
				<?php 
				$item=__("Internal Vs. External Links");				
				$class="primary";
				$status="info-circle";
				
				?>
				
				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus">
						<div class="row">
							
							<h4><?php echo __("Total Internal Links?"); ?></h4>
							<p><?php echo $site_info->internal_link_count;?></p>

							<h4><?php echo __("Total External Links?"); ?></h4>
							<p><?php echo $site_info->external_link_count;?></p>


							<div class="col-12">
								<ul class="list-group">
									<li class="list-group-item active text-center"><?php echo __("Internal Links"); ?></li>  
									<div class="heading_styles">
										<?php 
											$internal_link=json_decode($site_info->internal_link,true);											
											foreach ($internal_link as $value) 
											{
												echo "<li class='list-group-item'>".$value["link"]."</li>";
											}
										?>
									</div>
								</ul>
							</div>
							<div class="col-12">
								<ul class="list-group">
									<li class="list-group-item active text-center"><?php echo __("External Links"); ?></li>  
									<div class="heading_styles">
										<?php 
											$external_link=json_decode($site_info->external_link,true);
											foreach ($external_link as $value) 
											{
												echo "<li class='list-group-item'>".$value["link"]."</li>";
											}
										?>
									</div>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<!-- </div> -->
		<!-- </div> -->
		<!--  Internal Vs. External Links end-->


		<!-- Domain IP Information -->
		<div class="row">
			<div class="col-12">
				<?php 
				$item=__("Domain IP Information");				
				$class="primary";
				$status="map-marker-alt";	
				$domain_ip_info = json_decode($site_info->domain_ip_info, true);	
				?>
				
				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fas fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus">
						<h4><?php echo __("IP"); ?>: <span class="font-weight-normal"><?php echo $domain_ip_info["ip"] ?? '';?></span></h4>

						<h4><?php echo __("City"); ?>: <span class="font-weight-normal"><?php echo $domain_ip_info["city"] ?? '';?></span></h4>

						<h4><?php echo __("Country"); ?>: <span class="font-weight-normal"><?php echo $domain_ip_info["country"] ?? '';?></span></h4>

						<h4><?php echo __("Time Zone"); ?>: <span class="font-weight-normal"><?php echo $domain_ip_info["time_zone"] ?? '';?></span></h4>

						<h4><?php echo __("Longitude"); ?>: <span class="font-weight-normal"><?php echo $domain_ip_info["longitude"] ?? '';?></span></h4>

						<h4><?php echo __("Latitude"); ?>: <span class="font-weight-normal"><?php echo $domain_ip_info["latitude"] ?? '';?></span></h4>
							
					</div>
				</div>
			</div>
		</div>
		<!-- end Domain Ip Information -->

		<!-- NoIndex , NoFollow, DoFollow Links start-->
		<div class="row">
			<div class="col-12">				
				<?php 
					$item=__("NoIndex , NoFollow, DoFollow Links");
					$long_recommendation=$recommendations['no_do_follow_recommendation'];
					
					$class="primary";
					$status="directions";
				?>

				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fas fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus">
						<div class="row">

							<h4><?php echo __("Total NoIndex Links"); ?>: <span class="font-weight-normal"><?php echo count(json_decode($site_info->noindex_list,true)); ?></span></h4>
							<h4><?php echo __("Total NoFollow Links"); ?>: <span class="font-weight-normal"><?php echo $site_info->nofollow_link_count; ?></span></h4>
							<h4><?php echo __("Total DoFollow Links"); ?>: <span class="font-weight-normal"><?php echo $site_info->dofollow_link_count; ?></span></h4>
							<h4><?php echo __("NoIndex Enabled by Meta Robot?"); ?>: <span class="font-weight-normal"><?php echo $site_info->noindex_by_meta_robot;?></span></h4>
							<h4><?php echo __("NoFollow Enabled by Meta Robot?"); ?>: <span class="font-weight-normal"><?php echo $site_info->nofollowed_by_meta_robot;?></span></h4>
							
						</div>

						<div class="row">
							<div class="col-12 <?php if($compare_report == 0) echo "col-md-6 col-lg-6"; else echo "col-md-6 col-lg-6"; ?>">
								<ul class="list-group pdf-heading">
									<li class="list-group-item active text-center"><?php echo __("NoIndex Links"); ?></li>  
									<div class="heading_styles">
										<?php 
											$noindex_list=json_decode($site_info->noindex_list,true);
											foreach ($noindex_list as $value) 
											{
												echo "<li class='list-group-item'>".$value."</li>";
											}
										?>
									</div>
								</ul>
							</div>
							<div class="col-12 <?php if($compare_report == 0) echo "col-md-6 col-lg-6"; else echo "col-md-6 col-lg-6"; ?>">
								<ul class="list-group pdf-heading">
									<li class="list-group-item active text-center"><?php echo __("NoFollow Links"); ?></li>
									<div class="heading_styles"> 
									<?php 
										$nofollow_links=json_decode($site_info->nofollow_link_list,true);
										foreach ($nofollow_links as $value) 
										{
											echo "<li class='list-group-item'>".$value."</li>";
										}
									?>
									</div>
								</ul>
							</div>
						</div>
						<br>
						
						<?php if($is_pdf != 1) : ?>
						<div class="row">
							<div class="col-12">
								<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
								<div class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></div>
							</div>
						</div>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!-- NoIndex , NoFollow, DoFollow Links end-->

		<!-- seo friendly link start-->
		<div class="row">
			<div class="col-12">				
				<?php 
					$value=json_decode($site_info->not_seo_friendly_link,true);
					$check=count($value);
					$item=__("SEO Friendly Links");
					$long_recommendation=$recommendations['seo_friendly_recommendation'];
					if($check==0) //ok
					{
						$class="success";
						$status="check";
						$short_recommendation=__("Links of your site are SEO friendly.");
					}
					else //error
					{
						$class="danger";
						$status="times";
						$short_recommendation=__("Some links of your site are not SEO friendly.");
					}
				?>
				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 780px; overflow-y:auto;"';?>>
						<div class="section-title mt-0"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead"><?php echo $short_recommendation; ?></p>

						<?php if($check > 0) { ?>
						<ul class="list-group pdf-heading">
							<li class="list-group-item active"><?php echo __('Not SEO Friendly Links'); ?></li>  
							<div class="heading_styles">
								<?php 
									foreach ($value as $val) {
										echo "<li class='list-group-item'>".$val."</li>";
									}
								?>
							</div>
						</ul>
						<?php } ?>

						<?php if($is_pdf != 1) : ?>
						<br>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--  seo friendly link end-->

		<!-- favicon start-->
		<div class="row">
			<div class="col-12">				
				<?php 
					$check=$site_info->is_favicon_found;
					$item=__("Favicon");
					$long_recommendation="<a target='_BLANK' href='http://blog.woorank.com/2014/07/favicon-seo/'><i class='fa fa-hand-o-right'></i>  Learn more</a>";
					if($check=="0") //error
					{
						$class="warning";
						$status="exclamation-circle";
						$short_recommendation=__("Your site does not have favicon.");
					}
					else //ok
					{
						$class="success";
						$status="check";
						$short_recommendation=__("Your site have favicon.");
					}
				?>
				
				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 250px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($is_pdf != 1) : ?>
						<div class="section-title mt-0 item-header"><?php echo $recommendation_word ?></div>
						<p class="section-lead alert alert-light logn-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--  favicon end-->

		<!-- img alt start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$value=json_decode($site_info->image_not_alt_list,true);
				$check=$site_info->image_without_alt_count;
				$item=__("Image 'alt' Test");
				$long_recommendation=$recommendations['img_alt_recommendation'];
				if($check=="0") //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Your site does not have any image without alt text.");
				}
				else //warning
				{
					$class="warning";
					$status="exclamation-circle";
					$short_recommendation=__("Your site have").' '.$check.' '.__("images without alt text.");
				}
				?>
				
				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 600px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($check > 0) { ?>
						<ul class="list-group pdf-heading">
							<li class="list-group-item active"><?php echo __('Images Without alt'); ?></li>  
							<div class="heading_styles">
								<?php 
									foreach ($value as $val) {
										echo "<li class='list-group-item'>".$val."</li>";
									}
								?>
							</div>
						</ul>
						<?php } ?>

						<?php if($is_pdf != 1) : ?>
						<br>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--  img alt end-->

		<!-- doctype start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$value=$site_info->doctype;
				$check=$site_info->doctype_is_exist; 
				$item=__("DOC Type");
				$long_recommendation=$recommendations['doc_type_recommendation'];
				if($check=="0") //error
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Page do not have doc type");
				}
				else //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Page have doc type.");
				}
				?>
				
				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 300px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo "<b>".$item."</b> : ".$value; ?></div>

						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($is_pdf != 1) : ?>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!-- doctype end-->

		<!-- depreciate tag start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$value=json_decode($site_info->depreciated_html_tag,true);
				$check=array_sum($value);
				$item=__("Depreciated HTML Tag");
				$long_recommendation=$recommendations['depreciated_html_recommendation'];
				if($check==0) //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Your site does not have any depreciated HTML tag.");
				}
				else //warning
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Your site have").' '.$check.' '.__("depreciated HTML tags.");
				}
				?>

				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 600px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($check > 0) { ?>
						<ul class="list-group pdf-heading">
							<li class="list-group-item active"><?php echo __('Depreciated HTML Tags'); ?></li>  
							<div class="heading_styles">
								<?php 
									foreach ($value as $key=>$val) 
									{
										echo "<li class='list-group-item'>".$key." : ".$val."</li>";
									}
								?>
							</div>
						</ul>
						<?php } ?>

						<?php if($is_pdf != 1) : ?>
						<br>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--  depreciate tag end-->

		<!-- html page size start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$value=round($site_info->total_page_size_general)." KB";
				$check=$value; 
				$item=__("HTML Page Size");
				$long_recommendation=$recommendations['html_page_size_recommendation'];
				if($check>100) // warning
				{
					$class="warning";
					$status="exclamation-circle";
					$short_recommendation=__("HTML page size is > 100KB");
				}
				else // ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("HTML page size is <= 100KB");
				}
				?>

				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 600px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo "<b>".$item."</b> : ".$value; ?></div>

						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($is_pdf != 1) : ?>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--  html page size end-->

		<!-- GZIP Compression start-->
		<div class="row">
			<div class="col-12">				
				<?php 

				$value=round($site_info->page_size_gzip)." KB";
				$check=$site_info->is_gzip_enable; 
				$item=__("GZIP Compression");
				$item2="GZIP Compressed Size";
				$long_recommendation=$recommendations['gzip_recommendation'];
				if($check=="0") // warning
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("GZIP compression is disabled.");
				}
				else // ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("GZIP compression is enabled.");
					if(round($site_info->page_size_gzip) > 33) 
					{
						$short_recommendation.=__("GZIP compressed size should be < 33KB");
						$class="danger";
						$status="times";
					}
				}
				?>

				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 480px; overflow-y:auto;"';?>>
						<?php if($check == "1") { ?>
							<div class="section-title mt-0 item-header"><?php echo "<b>".$item2."</b> : ".$value; ?></div>
						<?php } ?>

						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($is_pdf != 1) : ?>
						<div class="section-title mt-0" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!-- GZIP Compression end-->

		<!-- inline css start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$value=json_decode($site_info->inline_css,true);
				$check=count($value);
				$item=__("Inline CSS");
				$long_recommendation=$recommendations['inline_css_recommendation'];
				if($check==0) //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Your site does not have any inline css.");
				}
				else //warning
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Your site have").' '.$check.' '.__("inline css.");
				}
				?>

				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 500px; overflow-y:auto;"';?>>
						<div class="section-title mt-0"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead"><?php echo $short_recommendation; ?></p>

						<?php if($check > 0) { ?>
						<ul class="list-group pdf-heading">
							<li class="list-group-item active"><?php echo __('Inline CSS'); ?></li>  
							<div class="heading_styles">
								<?php 
									foreach ($value as $val) {
										echo "<li class='list-group-item'>".$val."</li>";
									}
								?>
							</div>
						</ul>
						<?php } ?>

						<?php if($is_pdf != 1) : ?>
						<br>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!-- inline css end-->

		<!--  internal css start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$value=json_decode($site_info->internal_css,true);
				$check=count($value);
				$item=__("Internal CSS");
				$long_recommendation=$recommendations['internal_css_recommendation'];
				if($check==0) //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Your site does not have any internal css.");
				}
				else //warning
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Your site have").' '.$check.' '.__("internal css.");
				}
				?>

				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 300px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($is_pdf != 1) : ?>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--internal css end-->

		<div class="row">
			<div class="col-12">				
				<!-- micro data schema start-->
				<?php 
				$value=json_decode($site_info->micro_data_schema_list,true);
				$check=count($value);
				$item=__("Micro Data Schema Test");
				$long_recommendation=$recommendations['micro_data_recommendation'];
				if($check>0) //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Site passed micro data schema test.").' '.$check.' '.__("results found.");
				}
				else //error
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Site failed micro data schema test.");
				}
				?>
				
				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 450px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($check > 0) { ?>
						<ul class="list-group pdf-heading">
							<li class="list-group-item active"><?php echo __('Micro data schema list'); ?></li>  
							<div class="heading_styles">
								<?php 
									foreach ($value as $val) {
										echo "<li class='list-group-item'>".$val."</li>";
									}
								?>
							</div>
						</ul>
						<?php } ?>

						<?php if($is_pdf != 1) : ?>
						<br>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--  micro data schema end-->

		<!-- ip dns start-->
		<div class="row">
			<div class="col-12">				
				<?php 
					$item=__("IP & DNS Report");				
					$class="primary";
					$status="info-circle";
				?>
				
				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus">

						<h4><?php echo __("IPv4"); ?>: <span class="font-weight-normal"><?php echo $site_info->ip ?? '';?></span></h4>
						<h4><?php echo __("IPv6"); ?>: <span class="font-weight-normal"><?php if($site_info->is_ipv6_compatiable==0) echo "<small>".__("Not Compatiable")."</small>"; else echo $site_info->ipv6;?></span></h4>

						<?php 
						$dns_report=json_decode($site_info->dns_report,true);
						if(count($dns_report)>0)
						{ ?>
							<div class="row">
								<div class="col-12">
									<div class="section-title mt-0 item-header"><?php echo __('DNS Report'); ?></div>
									<div class="section-lead">
										<div class="table-responsive">
											<table class="table table-sm table-bordered table-hover text-center">
												<thead>
													<tr>
														<th><?php echo __("SL"); ?></th>
														<th><?php echo __("Host"); ?></th>
														<th><?php echo __("Class"); ?></th>
														<th><?php echo __("TTL"); ?></th>
														<th><?php echo __("Type"); ?></th>
														<th><?php echo __("PRI"); ?></th>
														<th><?php echo __("Target"); ?></th>
														<th><?php echo __("IP"); ?></th>
													</tr>
												</thead>
												
												<tbody>
													<?php 
														$sl=0;
														foreach ($dns_report as $value) 
														{
															$sl++;
															if(!isset($value["host"]))  $value["host"]="";
															if(!isset($value["class"])) $value["class"]="";
															if(!isset($value["ttl"]))   $value["ttl"]="";
															if(!isset($value["type"]))  $value["type"]="";
															if(!isset($value["pri"])) 	$value["pri"]="";
															if(!isset($value["target"]))$value["target"]="";
															if(!isset($value["ip"])) 	$value["ip"]="";
															if($value["type"]=="AAAA")
																$value["ip"]=$value["ipv6"];
														
															echo "<tr>";
																echo "<td>".$sl."</td>";
																echo "<td>".$value["host"]."</td>";
																echo "<td>".$value["class"]."</td>";
																echo "<td>".$value["ttl"]."</td>";
																echo "<td>".$value["type"]."</td>";
																echo "<td>".$value["pri"]."</td>";
																echo "<td>".$value["target"]."</td>";
																echo "<td>".$value["ip"]."</td>";
															echo "</tr>";
														}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<!--  ip dns end-->

		<!-- ip can start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$check=$site_info->is_ip_canonical; 
				$item=__("IP Canonicalization Test");
				$long_recommendation=$recommendations['ip_canonicalization_recommendation'];
				if($check=="0") //error
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Site failed IP canonicalization test.");
				}
				else //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Site passed IP canonicalization test.");
				}
				?>
				
				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 300px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($is_pdf != 1) : ?>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--  ip can end-->

		<!-- url can start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$check=$site_info->is_url_canonicalized; 
				$item=__("URL Canonicalization Test");
				$long_recommendation=$recommendations['url_canonicalization_recommendation'];
				if($check=="0") //error
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Site failed URL canonicalization test.");
				}
				else //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Site passed URL canonicalization test.");
				}
				?>

				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 450px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($is_pdf != 1) : ?>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--  url can end-->

		<!--  plain email start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$value=json_decode($site_info->email_list,true);
				$check=count($value);
				$item=__("Plain Text Email Test");
				$long_recommendation=$recommendations['plain_email_recommendation'];
				if($check==0) //ok
				{
					$class="success";
					$status="check";
					$short_recommendation=__("Site passed plain text email test. No plain text email found.");
				}
				else //warning
				{
					$class="danger";
					$status="times";
					$short_recommendation=__("Site failed plain text email test.").' '.$check.' '.__("plain text email found.");
				}
				?>

				<div class="card card-<?php echo $class; ?>">
					<div class="card-header">
						<h4 class="text-<?php echo $class; ?>"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 600px; overflow-y:auto;"';?>>
						<div class="section-title mt-0 item-header"><?php echo __('Short Recommendation'); ?></div>
						<p class="section-lead short-recom"><?php echo $short_recommendation; ?></p>

						<?php if($check > 0) { ?>
						<ul class="list-group pdf-heading">
							<li class="list-group-item active"><?php echo __('Plain Text Email List'); ?></li>  
							<div class="heading_styles">
								<?php 
									foreach ($value as $val) {
										echo "<li class='list-group-item'>".$val."</li>";
									}
								?>
							</div>
						</ul>
						<?php } ?>

						<?php if($is_pdf != 1) : ?>
						<br>
						<div class="section-title mt-0 item-header" title="<?php echo $item; ?> : <?php echo $recommendation_word; ?>"><?php echo $recommendation_word; ?></div>
						<p class="section-lead alert alert-light long-recom"><?php echo $long_recommendation; ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!--   plain email end-->

		<!-- curl response start-->
		<div class="row">
			<div class="col-12">				
				<?php 
				$item=__("cURL Response");				
				$class="primary";
				$status="info-circle";
				
				?>
				
				<div class="card card-<?php echo $class; ?>">
					<div class="card-header bg-<?php echo $class; ?>">
						<h4 class="text-white"><i class="fa fa-<?php echo $status;?>"></i> <?php echo $item; ?></h4>
						<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
					</div>

					<div class="card-body chart-responsive minus p-0" <?php if($compare_report == 1 && $is_pdf == 0) echo 'style="height: 500px; overflow-y:auto;"';?>>
						<ul class="list-group pdf-heading" style="padding:0 15px;">
							<div class="row">
								<?php $curl_response=json_decode($site_info->general_curl_response,true); ?>
								<?php $sl =0; ?>
								<?php foreach ($curl_response as $key => $value) { 
									if(is_array($value)) $value=implode(",", $value);
									$sl++;
								?>
									<div class="col-12 col-md-6 p-0">
										<li class="list-group-item rounded-0 border-top-0"><b><?php echo str_replace("_"," ",$key); ?></b> : <span class="text-xs"><?php echo $value; ?></span></li>
									</div>

								<?php } ?>


							</div>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- curl response end-->
	
		<div class="row">
			<div class="col-12">
				<div class="card card-primary">
					<div class="card-header">
						<h4><i class="fas fa-mobile-alt"></i> <?php echo __('PageSpeed Insights (Mobile)'); ?></h4>
						<div class="card-header-action">
							<a data-collapse="#mobile-collapse" href="#"><i class="fas fa-minus"></i></a>
						</div>
					</div>

					<div class="card-body" id="mobile-collapse">
						<?php if (empty($mobile_lighthouseresult_categories)): ?>
							<div class="alert alert-warning alert-has-icon">
							  <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
							  <div class="alert-body break-word">
							    <div class="alert-title"><?php echo __("Warning"); ?></div>
							    <?php echo isset($site_info->mobile_google_api_error) ? $site_info->mobile_google_api_error : ""; ?><br>
							    <a target='_BLANK' href="https://console.developers.google.com/apis/library"><?php echo __("Enable Google PageInsights API from here"); ?></a>
							  </div>
							</div>
						<?php else: ?>
							<div class="row">
								<div class="col-12 col-md-6">
									<?php if($is_pdf==1) : ?>
									<div class="card card-primary">
										<div class="card-header">
											<h4><i class="fas fa-star-half-alt"></i> <?php echo __('Performance'); ?></h4>
											<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
										</div>
										<div class="card-body chart-responsive minus">
											<div class="progress score_card">
											  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $mobile_score; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $mobile_score; ?>%"><?php echo $mobile_score; ?></div>
											</div>
										</div>
									</div>
									<?php else : ?>
										<p class="text-center position-relative">
										    <div class="d-inline w-120 h-120"><canvas width="120" height="120"></canvas><input type="text" class="dial knob" data-readonly="true" value="<?php echo $mobile_score; ?>" data-width="120" data-height="120" data-fgcolor="#6777ef" data-thickness=".1" readonly="readonly" class="width: 64px; height: 40px; position: absolute; vertical-align: middle; margin-top: 40px; margin-left: -92px; border: 0px; background: none; font: bold 24px Arial; text-align: center; color: rgb(103, 119, 239); padding: 0px; -webkit-appearance: none;"></div>
										</p>
										<h4 class="text-warning ml-21" ><?php echo __('Performance'); ?></h4>
									<?php endif ?>
								</div>
								<div class="col-12 col-md-6">
									<ul class="list-group <?php if($is_pdf == 1) echo "pdf-heading";?>">
										<div class="<?php if($is_pdf == 1) echo "heading_styles";?>" <?php if($is_pdf == 1) echo "style='height:auto'"?>>
											<li class="list-group-item">
												<?php echo __("Emulated Form Factor"); ?>
												<span class="badge badge-primary badge-pill">
													<?php  

														if(isset($mobile_lighthouseresult_configsettings['emulatedFormFactor']))
															echo ucwords($mobile_lighthouseresult_configsettings['emulatedFormFactor']);
													?>
														
													</span>
											</li>
											<li class="list-group-item">
												<?php echo __("Locale") ?>
												<span class="badge badge-primary badge-pill">
													<?php 
														if(isset($mobile_lighthouseresult_configsettings['locale']))
															echo ucwords($mobile_lighthouseresult_configsettings['locale']);
													 ?>
												</span>
											</li>									
											<li class="list-group-item">
												<?php echo __("Category") ?>
												<span class="badge badge-primary badge-pill">
													<?php 
														if(isset($mobile_lighthouseresult_configsettings['onlyCategories'][0]))
															echo ucwords($mobile_lighthouseresult_configsettings['onlyCategories'][0]);
													 ?>
												</span>
											</li>
										</div>
									</ul>
								</div>
							</div>
							<div class="row mt-5">
								<div class="<?php if($compare_report == 1) echo "col-12"; else echo "col-12 col-md-8"; ?> ">
									<ul class="list-group pdf-heading">
										<li class="list-group-item active"><?php echo __("Field Data"); ?></li>
										<div class="heading_styles h-auto" >
											<li class="list-group-item">
												<?php echo __('First Contentful Paint (FCP)'); ?>
												<span class="badge badge-primary badge-pill">
												   <?php 
												   if(isset($mobile_loadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['percentile']))
												       echo $mobile_loadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['percentile'].' ms';
												    ?>
												        
												</span>
											</li>
											<li class="list-group-item">
												<?php echo __('FCP Metric Category'); ?>
												<span class="badge badge-primary badge-pill">
												    <?php 
												    if(isset($mobile_loadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['category']))
												        echo $mobile_loadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['category'];
												     ?>    
												</span>
											</li>
											<li class="list-group-item">
												<?php echo __('First Input Delay (FID)'); ?>
												<span class="badge badge-primary badge-pill">
												   <?php 

												   if(isset($mobile_loadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['percentile']))
												       echo $mobile_loadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['percentile'].' ms';
												    ?>
												        
												</span>
											</li>
											<li class="list-group-item">
												<?php echo __('FID Metric Category'); ?>
												<span class="badge badge-primary badge-pill">
												   <?php 

												   if(isset($mobile_loadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['category']))
												       echo $mobile_loadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['category'];
												    ?>
												        
												</span>
											</li>
											<li class="list-group-item">
												<?php echo __('Overall Category'); ?>
												<span class="badge badge-primary badge-pill">
												    <?php 
												    if(isset($mobile_loadingexperience_metrics['overall_category']))
												        echo $mobile_loadingexperience_metrics['overall_category'];
												     ?>
												        
												</span>
											</li>
										</div>
									</ul>
								</div>
								<div class="<?php if($compare_report ==1) echo "col-12 mt-5"; else echo "col-12 col-md-4 pl-4"; ?> ">
									<div class="text-center"
										<?php 
											$bgpos = '';
											if($is_pdf == 1) $bgpos = "background-position: top center;padding-left:12px!important;";

											if($compare_report ==1) echo 'style="padding-left:12px;height:530px;background: url('.asset("assets/images/mobile.png").') no-repeat !important; '.$bgpos.'"'; 
											else echo 'style="padding-left:12px;height:530px;background: url('.asset("assets/images/mobile.png").') no-repeat !important; '.$bgpos.'"'; 
										?> 
									>
										<?php 
																
										if(isset($mobile_lighthouseresult_audits['final-screenshot']['details']['data']))
										{

											echo '<img src="'.$mobile_lighthouseresult_audits['final-screenshot']['details']['data'].'" width="225px" style="margin-top:52px;">';
										} 

										?>
									</div>
								</div>
							</div>
							<div class="row mt-4">
								<div class="<?php if($compare_report ==1) echo "col-12"; else echo "col-12 col-md-6" ?>">
	                                <ul class="list-group pdf-heading">
	                                    <li class="list-group-item active"> <?php echo __('Origin Summary'); ?> </li>
	                                    <div class="heading_styles h-auto" >
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First Contentful Paint (FCP)'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($mobile_originloadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['percentile']))
	                                    	            echo $mobile_originloadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['percentile'].' ms';
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('FCP Metric Category'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($mobile_originloadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['category']))
	                                    	            echo $mobile_originloadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['category'];
	                                    	         ?>  
	                                    	    </span>
	                                    	</li>
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First Input Delay (FID)'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 

	                                    	       if(isset($mobile_originloadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['percentile']))
	                                    	           echo $mobile_originloadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['percentile'].' ms';
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('FID Metric Category'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 
	                                    	       if(isset($mobile_originloadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['category']))
	                                    	           echo $mobile_originloadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['category'];
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('Overall Category'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($mobile_originloadingexperience_metrics['overall_category']))
	                                    	            echo $mobile_originloadingexperience_metrics['overall_category'];
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>
	                                    </div>
	                                </ul>

								</div>
								<div class="<?php if($compare_report ==1) echo "col-12 mt-5"; else echo "col-12 col-md-6" ?>">
	                                <ul class="list-group pdf-heading">
	                                    <li class="list-group-item active"> <?php echo __('Lab Data'); ?> 
	                                    </li>
	                                    <div class="heading_styles h-auto" >
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First Contentful Paint'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($mobile_lighthouseresult_audits['first-contentful-paint']['displayValue']))
	                                    	            echo $mobile_lighthouseresult_audits['first-contentful-paint']['displayValue'];
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First Meaningful Paint'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($mobile_lighthouseresult_audits['first-meaningful-paint']['displayValue']))
	                                    	            echo $mobile_lighthouseresult_audits['first-meaningful-paint']['displayValue'];
	                                    	        ?>
	                                    	        
	                                    	    </span>
	                                    	</li>
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('Speed Index'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 

	                                    	       if(isset($mobile_lighthouseresult_audits['speed-index']['displayValue']))
	                                    	         echo $mobile_lighthouseresult_audits['speed-index']['displayValue'];
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First CPU Idle'); ?> 
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 
	                                    	       if(isset($mobile_lighthouseresult_audits['first-cpu-idle']['displayValue']))
	                                    	           echo $mobile_lighthouseresult_audits['first-cpu-idle']['displayValue'];
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('Time to Interactive'); ?> 
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($mobile_lighthouseresult_audits['interactive']['displayValue']))
	                                    	            echo $mobile_lighthouseresult_audits['interactive']['displayValue'];
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    

	                                    	<li class="list-group-item">
	                                    	    <?php echo __('Max Potential First Input Delay'); ?> 
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($mobile_lighthouseresult_audits['max-potential-fid']['displayValue']))
	                                    	            echo $mobile_lighthouseresult_audits['max-potential-fid']['displayValue'];
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>
	                                    </div>
	                                </ul>
								</div>
							</div>
							<div class="row mt-5">
								<div class="col-12">
								    <div class="card card-primary">
								        <div class="card-header">
								            <h4 class="text-white bg-info"><?php echo __("Audit Data") ?></h4>
								            <div class="card-header-action"><i class="fa fa-minus minus"></i></div>
								        </div>

								          <div class="card-body chart-responsive minus p-0">
											<div class="row mt-5">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['resource-summary']['title']))
																    echo $mobile_lighthouseresult_audits['resource-summary']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['resource-summary']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['resource-summary']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['resource-summary']['description'])){

											                $resource_sum = explode('[',$mobile_lighthouseresult_audits['resource-summary']['description']);

											                echo '<p>'.$resource_sum[0].'<b><a class="text-danger" target="_BLANK" href="https://developers.google.com/web/tools/lighthouse/audits/budgets">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['time-to-first-byte']['title']))
																    echo $mobile_lighthouseresult_audits['time-to-first-byte']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['time-to-first-byte']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['time-to-first-byte']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['time-to-first-byte']['description'])){

											                $time_to_first_byte = explode('[',$mobile_lighthouseresult_audits['time-to-first-byte']['description']);

											                echo '<p>'.$time_to_first_byte[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/time-to-first-byte">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['render-blocking-resources']['title']))
																    echo $mobile_lighthouseresult_audits['render-blocking-resources']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['render-blocking-resources']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['render-blocking-resources']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['render-blocking-resources']['description'])){

											                $render_blocking = explode('[',$mobile_lighthouseresult_audits['render-blocking-resources']['description']);

											                echo '<p>'.$render_blocking[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/render-blocking-resources">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['uses-optimized-images']['title']))
																    echo $mobile_lighthouseresult_audits['uses-optimized-images']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['uses-optimized-images']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['uses-optimized-images']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['uses-optimized-images']['description'])){

											                $render_blocking = explode('[',$mobile_lighthouseresult_audits['uses-optimized-images']['description']);

											                echo '<p>'.$render_blocking[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/uses-optimized-images">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['uses-text-compression']['title']))
																    echo $mobile_lighthouseresult_audits['uses-text-compression']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['uses-text-compression']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['uses-text-compression']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['uses-text-compression']['description'])){

											                $text_compresseion = explode('[',$mobile_lighthouseresult_audits['uses-text-compression']['description']);

											                echo '<p>'.$text_compresseion[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/uses-text-compression">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['uses-long-cache-ttl']['title']))
																    echo $mobile_lighthouseresult_audits['uses-long-cache-ttl']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['uses-long-cache-ttl']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['uses-long-cache-ttl']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['uses-long-cache-ttl']['description'])){

											                $uses_long_cache = explode('[',$mobile_lighthouseresult_audits['uses-long-cache-ttl']['description']);

											                echo '<p>'.$uses_long_cache[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/uses-long-cache-ttl">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['third-party-summary']['title']))
																    echo $mobile_lighthouseresult_audits['third-party-summary']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['third-party-summary']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['third-party-summary']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['third-party-summary']['description'])){

											                $third_party_summary = explode('[',$mobile_lighthouseresult_audits['third-party-summary']['description']);

											                echo '<p>'.$third_party_summary[0].'<b><a class="text-danger" target="_BLANK" href="https://developers.google.com/web/fundamentals/performance/optimizing-content-efficiency/loading-third-party-javascript">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['estimated-input-latency']['title']))
																    echo $mobile_lighthouseresult_audits['estimated-input-latency']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['estimated-input-latency']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['estimated-input-latency']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['estimated-input-latency']['description'])){

											                $third_party_summary = explode('[',$mobile_lighthouseresult_audits['estimated-input-latency']['description']);

											                echo '<p>'.$third_party_summary[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/estimated-input-latency">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['first-contentful-paint-3g']['title']))
																    echo $mobile_lighthouseresult_audits['first-contentful-paint-3g']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['first-contentful-paint-3g']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['first-contentful-paint-3g']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['first-contentful-paint-3g']['description'])){

											                $fcp3g = explode('[',$mobile_lighthouseresult_audits['first-contentful-paint-3g']['description']);

											                echo '<p>'.$fcp3g[0].'<b><a class="text-danger" target="_BLANK" href="https://developers.google.com/web/tools/lighthouse/audits/first-contentful-paint">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['total-blocking-time']['title']))
																    echo $mobile_lighthouseresult_audits['total-blocking-time']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['total-blocking-time']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['total-blocking-time']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['total-blocking-time']['description'])){

											                $total_blocking_time1 = explode('[',$mobile_lighthouseresult_audits['total-blocking-time']['description']);

											                echo '<p>'.$total_blocking_time1[0].'</p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['bootup-time']['title']))
																    echo $mobile_lighthouseresult_audits['bootup-time']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['bootup-time']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['bootup-time']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['bootup-time']['description'])){

											                $boottime = explode('[',$mobile_lighthouseresult_audits['bootup-time']['description']);

											                echo '<p>'.$boottime[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/bootup-time">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['offscreen-images']['title']))
																    echo $mobile_lighthouseresult_audits['offscreen-images']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['offscreen-images']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['offscreen-images']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['offscreen-images']['description'])){

											                $offscreen_des = explode('[',$mobile_lighthouseresult_audits['offscreen-images']['description']);

											                echo '<p>'.$offscreen_des[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/offscreen-images">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['network-server-latency']['title']))
																    echo $mobile_lighthouseresult_audits['network-server-latency']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['network-server-latency']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['network-server-latency']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['network-server-latency']['description'])){

											                $network_server_lat = explode('[',$mobile_lighthouseresult_audits['network-server-latency']['description']);

											                echo '<p>'.$network_server_lat[0].'<b><a class="text-danger" target="_BLANK" href="https://hpbn.co/primer-on-web-performance/#analyzing-the-resource-waterfall">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['uses-responsive-images']['title']))
																    echo $mobile_lighthouseresult_audits['uses-responsive-images']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['uses-responsive-images']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['uses-responsive-images']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['uses-responsive-images']['description'])){

											                $uses_responsive = explode('[',$mobile_lighthouseresult_audits['uses-responsive-images']['description']);

											                echo '<p>'.$uses_responsive[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/uses-responsive-images?utm_source=lighthouse&utm_medium=unknown">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['unused-css-rules']['title']))
																    echo $mobile_lighthouseresult_audits['unused-css-rules']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['unused-css-rules']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['unused-css-rules']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['unused-css-rules']['description'])){

											                $unused_css = explode('[',$mobile_lighthouseresult_audits['unused-css-rules']['description']);

											                echo '<p>'.$unused_css[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/unused-css-rules">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['total-byte-weight']['title']))
																    echo $mobile_lighthouseresult_audits['total-byte-weight']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['total-byte-weight']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['total-byte-weight']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['total-byte-weight']['description'])){

											                $total_byte = explode('[',$mobile_lighthouseresult_audits['total-byte-weight']['description']);

											                echo '<p>'.$total_byte[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/total-byte-weight">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['mainthread-work-breakdown']['title']))
																    echo $mobile_lighthouseresult_audits['mainthread-work-breakdown']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['mainthread-work-breakdown']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['mainthread-work-breakdown']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['mainthread-work-breakdown']['description'])){

											                $mainthred_work = explode('[',$mobile_lighthouseresult_audits['mainthread-work-breakdown']['description']);

											                echo '<p>'.$mainthred_work[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/mainthread-work-breakdown">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['uses-webp-images']['title']))
																    echo $mobile_lighthouseresult_audits['uses-webp-images']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['uses-webp-images']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['uses-webp-images']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['uses-webp-images']['description'])){

											                $uses_web_images = explode('[',$mobile_lighthouseresult_audits['uses-webp-images']['description']);

											                echo '<p>'.$uses_web_images[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/uses-webp-images">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['critical-request-chains']['title']))
																    echo $mobile_lighthouseresult_audits['critical-request-chains']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['critical-request-chains']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['critical-request-chains']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['critical-request-chains']['description'])){

											                $critical_request_chains = explode('[',$mobile_lighthouseresult_audits['critical-request-chains']['description']);

											                echo '<p>'.$critical_request_chains[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/critical-request-chains">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['dom-size']['title']))
																    echo $mobile_lighthouseresult_audits['dom-size']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['dom-size']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['dom-size']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['dom-size']['description'])){

											                $dom_size1 = explode('[',$mobile_lighthouseresult_audits['dom-size']['description']);

											                echo '<p>'.$dom_size1[0].'<b><a class="text-danger" target="_BLANK" href="https://developers.google.com/web/fundamentals/performance/rendering/reduce-the-scope-and-complexity-of-style-calculations">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['redirects']['title']))
																    echo $mobile_lighthouseresult_audits['redirects']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['redirects']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['redirects']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['redirects']['description'])){

											                $redirects_des = explode('[',$mobile_lighthouseresult_audits['redirects']['description']);

											                echo '<p>'.$redirects_des[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/redirects">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['unminified-javascript']['title']))
																    echo $mobile_lighthouseresult_audits['unminified-javascript']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['unminified-javascript']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['unminified-javascript']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['unminified-javascript']['description'])){

											                $unminified_js = explode('[',$mobile_lighthouseresult_audits['unminified-javascript']['description']);

											                echo '<p>'.$unminified_js[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/unminified-javascript">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['user-timings']['title']))
																    echo $mobile_lighthouseresult_audits['user-timings']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['user-timings']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['user-timings']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['user-timings']['description'])){

											                $user_times = explode('[',$mobile_lighthouseresult_audits['user-timings']['description']);

											                echo '<p>'.$user_times[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/user-timings">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($mobile_lighthouseresult_audits['network-rtt']['title']))
																    echo $mobile_lighthouseresult_audits['network-rtt']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($mobile_lighthouseresult_audits['network-rtt']['displayValue']))
											                		echo $mobile_lighthouseresult_audits['network-rtt']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($mobile_lighthouseresult_audits['network-rtt']['description'])){

											                $network_rtt = explode('[',$mobile_lighthouseresult_audits['network-rtt']['description']);

											                echo '<p>'.$network_rtt[0].'<b><a class="text-danger" target="_BLANK" href="https://hpbn.co/primer-on-latency-and-bandwidth/">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>	
								          </div>
								     </div>
								</div>
							</div>

						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>	

		<div class="row">
			<div class="col-12">
				<div class="card card-primary">
					<div class="card-header">
						<h4><i class="fas fa-desktop"></i> <?php echo __('PageSpeed Insights (Desktop)'); ?></h4>
						<div class="card-header-action">
							<a data-collapse="#desktop-collapse" href="#"><i class="fas fa-minus"></i></a>
						</div>
					</div>

					<div class="card-body" id="desktop-collapse">

						<?php if (empty($desktop_lighthouseresult_categories)): ?>
							<div class="alert alert-warning alert-has-icon">
							  <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
							  <div class="alert-body break-word" >
							    <div class="alert-title"><?php echo __("Warning"); ?></div>
							    <?php echo isset($site_info->desktop_google_api_error) ? $site_info->mobile_google_api_error : ""; ?><br>
							    <a target='_BLANK' href="https://console.developers.google.com/apis/library"><?php echo __("Enable Google PageInsights API from here"); ?></a>
							  </div>
							</div>
						<?php else: ?>
							<div class="row">
								<div class="col-12 col-md-6">
								<?php if($is_pdf==1) : ?>
								<div class="card card-primary">
									<div class="card-header">
										<h4><i class="fas fa-star-half-alt"></i> <?php echo __('Performance'); ?></h4>
										<div class="card-header-action"><i class="fa fa-minus minus"></i></div>
									</div>
									<div class="card-body chart-responsive minus">
										<div class="progress score_card">
										  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $desktop_score; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $desktop_score; ?>%"><?php echo $desktop_score; ?></div>
										</div>
									</div>
								</div>
								<?php else : ?>
									<p class="text-center position-relative">
									    <div class="d-inline w-120 h-120"><canvas width="120" height="120"></canvas><input type="text" class="dial knob" data-readonly="true" value="<?php echo $desktop_score; ?>" data-width="120" data-height="120" data-fgcolor="#6777ef" data-thickness=".1" readonly="readonly" id="custom-input"></div>
									</p>
									<h4 class="text-warning ml-21" ><?php echo __('Performance'); ?></h4>
								<?php endif ?>						
								</div>
								<div class="col-12 col-md-6">
									<ul class="list-group pdf-heading">
										<div class="heading_styles">
											<li class="list-group-item">
												<?php echo __("Emulated Form Factor"); ?>
												<span class="badge badge-primary badge-pill">
													<?php  

														if(isset($desktop_lighthouseresult_configsettings['emulatedFormFactor']))
															echo ucwords($desktop_lighthouseresult_configsettings['emulatedFormFactor']);
													?>
														
													</span>
											</li>
											<li class="list-group-item">
												<?php echo __("Locale") ?>
												<span class="badge badge-primary badge-pill">
													<?php 
														if(isset($desktop_lighthouseresult_configsettings['locale']))
															echo ucwords($desktop_lighthouseresult_configsettings['locale']);
													 ?>
												</span>
											</li>									
											<li class="list-group-item">
												<?php echo __("Category") ?>
												<span class="badge badge-primary badge-pill">
													<?php 
														if(isset($desktop_lighthouseresult_configsettings['onlyCategories'][0]))
															echo ucwords($desktop_lighthouseresult_configsettings['onlyCategories'][0]);
													 ?>
												</span>
											</li>
										</div>
									</ul>
								</div>
							</div>
							<div class="row mt-5">
								<div class="col-12 col-md-6">
	                                <ul class="list-group pdf-heading">
	                                    <li class="list-group-item active"> <?php echo __('Field Data'); ?></li>
	                                    <div class="heading_styles h-auto" >
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First Contentful Paint (FCP)'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 
	                                    	       if(isset($desktop_loadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['percentile']))
	                                    	           echo $desktop_loadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['percentile'].' ms';
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('FCP Metric Category'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($desktop_loadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['category']))
	                                    	            echo $desktop_loadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['category'];
	                                    	         ?>    
	                                    	    </span>
	                                    	</li>
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First Input Delay (FID)'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 

	                                    	       if(isset($desktop_loadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['percentile']))
	                                    	           echo $desktop_loadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['percentile'].' ms';
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('FID Metric Category'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 

	                                    	       if(isset($desktop_loadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['category']))
	                                    	           echo $desktop_loadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['category'];
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('Overall Category'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($desktop_loadingexperience_metrics['overall_category']))
	                                    	            echo $desktop_loadingexperience_metrics['overall_category'];
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>
	                                    </div>
	                                </ul>
								</div>
								<div class="col-12 col-md-6 pl-4 text-center">
									<?php 
															
									if(isset($desktop_lighthouseresult_audits['final-screenshot']['details']['data']))
									{

										echo '<img src="'.$desktop_lighthouseresult_audits['final-screenshot']['details']['data'].'" class="img-thumbnail">';
									} 

									?>
								</div>
								<br>
							</div>
							<div class="row mt-5">
								<div class="<?php if($compare_report ==1) echo "col-12"; else echo "col-12 col-md-6" ?>">
	                                <ul class="list-group pdf-heading">
	                                    <li class="list-group-item active"> <?php echo __('Origin Summary'); ?></li>
	                                    <div class="heading_styles h-auto" >
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First Contentful Paint (FCP)'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($desktop_originloadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['percentile']))
	                                    	            echo $desktop_originloadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['percentile'].' ms';
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('FCP Metric Category'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($desktop_originloadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['category']))
	                                    	            echo $desktop_originloadingexperience_metrics['metrics']['FIRST_CONTENTFUL_PAINT_MS']['category'];
	                                    	         ?>  
	                                    	    </span>
	                                    	</li>
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First Input Delay (FID)'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 

	                                    	       if(isset($desktop_originloadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['percentile']))
	                                    	           echo $desktop_originloadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['percentile'].' ms';
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('FID Metric Category'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 
	                                    	       if(isset($desktop_originloadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['category']))
	                                    	           echo $desktop_originloadingexperience_metrics['metrics']['FIRST_INPUT_DELAY_MS']['category'];
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('Overall Category'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($desktop_originloadingexperience_metrics['overall_category']))
	                                    	            echo $desktop_originloadingexperience_metrics['overall_category'];
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>
	                                    </div>
	                                </ul>

								</div>
								<div class="<?php if($compare_report ==1) echo "col-12 mt-5"; else echo "col-12 col-md-6"; ?>">
	                                <ul class="list-group pdf-heading">
	                                    <li class="list-group-item active"> <?php echo __('Lab Data'); ?> 
	                                    </li>
	                                    <div class="heading_styles h-auto" >
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First Contentful Paint'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($desktop_lighthouseresult_audits['first-contentful-paint']['displayValue']))
	                                    	            echo $desktop_lighthouseresult_audits['first-contentful-paint']['displayValue'];
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First Meaningful Paint'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($desktop_lighthouseresult_audits['first-meaningful-paint']['displayValue']))
	                                    	            echo $desktop_lighthouseresult_audits['first-meaningful-paint']['displayValue'];
	                                    	        ?>
	                                    	        
	                                    	    </span>
	                                    	</li>
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('Speed Index'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 

	                                    	       if(isset($desktop_lighthouseresult_audits['speed-index']['displayValue']))
	                                    	         echo $desktop_lighthouseresult_audits['speed-index']['displayValue'];
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('First CPU Idle'); ?> 
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	       <?php 
	                                    	       if(isset($desktop_lighthouseresult_audits['first-cpu-idle']['displayValue']))
	                                    	           echo $desktop_lighthouseresult_audits['first-cpu-idle']['displayValue'];
	                                    	        ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    
	                                    	<li class="list-group-item">
	                                    	    <?php echo __('Time to Interactive'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($desktop_lighthouseresult_audits['interactive']['displayValue']))
	                                    	            echo $desktop_lighthouseresult_audits['interactive']['displayValue'];
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>                                    

	                                    	<li class="list-group-item">
	                                    	    <?php echo __('Max Potential First Input Delay'); ?>
	                                    	    <span class="badge badge-primary badge-pill">
	                                    	        <?php 
	                                    	        if(isset($desktop_lighthouseresult_audits['max-potential-fid']['displayValue']))
	                                    	            echo $desktop_lighthouseresult_audits['max-potential-fid']['displayValue'];
	                                    	         ?>
	                                    	            
	                                    	    </span>
	                                    	</li>
	                                    </div>
	                                </ul>
								</div>
							</div>
							<div class="row mt-5">
								<div class="col-12">
								    <div class="card card-primary">
								        <div class="card-header">
								            <h4 class="text-white bg-primary" ><?php echo __("Audit Data") ?></h4>
								            <div class="card-header-action"><i class="fa fa-minus minus"></i></div>
								        </div>

								        <div class="card-body chart-responsive minus p-0">
											<div class="row mt-5">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['resource-summary']['title']))
																    echo $desktop_lighthouseresult_audits['resource-summary']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['resource-summary']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['resource-summary']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['resource-summary']['description'])){

											                $resource_sum = explode('[',$desktop_lighthouseresult_audits['resource-summary']['description']);

											                echo '<p>'.$resource_sum[0].'<b><a class="text-danger" target="_BLANK" href="https://developers.google.com/web/tools/lighthouse/audits/budgets">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['time-to-first-byte']['title']))
																    echo $desktop_lighthouseresult_audits['time-to-first-byte']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['time-to-first-byte']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['time-to-first-byte']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['time-to-first-byte']['description'])){

											                $time_to_first_byte = explode('[',$desktop_lighthouseresult_audits['time-to-first-byte']['description']);

											                echo '<p>'.$time_to_first_byte[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/time-to-first-byte">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['render-blocking-resources']['title']))
																    echo $desktop_lighthouseresult_audits['render-blocking-resources']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['render-blocking-resources']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['render-blocking-resources']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['render-blocking-resources']['description'])){

											                $render_blocking = explode('[',$desktop_lighthouseresult_audits['render-blocking-resources']['description']);

											                echo '<p>'.$render_blocking[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/render-blocking-resources">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['uses-optimized-images']['title']))
																    echo $desktop_lighthouseresult_audits['uses-optimized-images']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['uses-optimized-images']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['uses-optimized-images']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['uses-optimized-images']['description'])){

											                $render_blocking = explode('[',$desktop_lighthouseresult_audits['uses-optimized-images']['description']);

											                echo '<p>'.$render_blocking[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/uses-optimized-images">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['uses-text-compression']['title']))
																    echo $desktop_lighthouseresult_audits['uses-text-compression']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['uses-text-compression']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['uses-text-compression']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['uses-text-compression']['description'])){

											                $text_compresseion = explode('[',$desktop_lighthouseresult_audits['uses-text-compression']['description']);

											                echo '<p>'.$text_compresseion[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/uses-text-compression">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['uses-long-cache-ttl']['title']))
																    echo $desktop_lighthouseresult_audits['uses-long-cache-ttl']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['uses-long-cache-ttl']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['uses-long-cache-ttl']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['uses-long-cache-ttl']['description'])){

											                $uses_long_cache = explode('[',$desktop_lighthouseresult_audits['uses-long-cache-ttl']['description']);

											                echo '<p>'.$uses_long_cache[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/uses-long-cache-ttl">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['third-party-summary']['title']))
																    echo $desktop_lighthouseresult_audits['third-party-summary']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['third-party-summary']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['third-party-summary']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['third-party-summary']['description'])){

											                $third_party_summary = explode('[',$desktop_lighthouseresult_audits['third-party-summary']['description']);

											                echo '<p>'.$third_party_summary[0].'<b><a class="text-danger" target="_BLANK" href="https://developers.google.com/web/fundamentals/performance/optimizing-content-efficiency/loading-third-party-javascript">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['estimated-input-latency']['title']))
																    echo $desktop_lighthouseresult_audits['estimated-input-latency']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['estimated-input-latency']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['estimated-input-latency']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['estimated-input-latency']['description'])){

											                $third_party_summary = explode('[',$desktop_lighthouseresult_audits['estimated-input-latency']['description']);

											                echo '<p>'.$third_party_summary[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/estimated-input-latency">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['first-contentful-paint-3g']['title']))
																    echo $desktop_lighthouseresult_audits['first-contentful-paint-3g']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['first-contentful-paint-3g']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['first-contentful-paint-3g']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['first-contentful-paint-3g']['description'])){

											                $fcp3g = explode('[',$desktop_lighthouseresult_audits['first-contentful-paint-3g']['description']);

											                echo '<p>'.$fcp3g[0].'<b><a class="text-danger" target="_BLANK" href="https://developers.google.com/web/tools/lighthouse/audits/first-contentful-paint">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['total-blocking-time']['title']))
																    echo $desktop_lighthouseresult_audits['total-blocking-time']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['total-blocking-time']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['total-blocking-time']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['total-blocking-time']['description'])){

											                $total_blocking_time1 = explode('[',$desktop_lighthouseresult_audits['total-blocking-time']['description']);

											                echo '<p>'.$total_blocking_time1[0].'</p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['bootup-time']['title']))
																    echo $desktop_lighthouseresult_audits['bootup-time']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['bootup-time']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['bootup-time']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['bootup-time']['description'])){

											                $boottime = explode('[',$desktop_lighthouseresult_audits['bootup-time']['description']);

											                echo '<p>'.$boottime[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/bootup-time">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['offscreen-images']['title']))
																    echo $desktop_lighthouseresult_audits['offscreen-images']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['offscreen-images']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['offscreen-images']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['offscreen-images']['description'])){

											                $offscreen_des = explode('[',$desktop_lighthouseresult_audits['offscreen-images']['description']);

											                echo '<p>'.$offscreen_des[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/offscreen-images">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['network-server-latency']['title']))
																    echo $desktop_lighthouseresult_audits['network-server-latency']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['network-server-latency']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['network-server-latency']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['network-server-latency']['description'])){

											                $network_server_lat = explode('[',$desktop_lighthouseresult_audits['network-server-latency']['description']);

											                echo '<p>'.$network_server_lat[0].'<b><a class="text-danger" target="_BLANK" href="https://hpbn.co/primer-on-web-performance/#analyzing-the-resource-waterfall">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['uses-responsive-images']['title']))
																    echo $desktop_lighthouseresult_audits['uses-responsive-images']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['uses-responsive-images']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['uses-responsive-images']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['uses-responsive-images']['description'])){

											                $uses_responsive = explode('[',$desktop_lighthouseresult_audits['uses-responsive-images']['description']);

											                echo '<p>'.$uses_responsive[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/uses-responsive-images?utm_source=lighthouse&utm_medium=unknown">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['unused-css-rules']['title']))
																    echo $desktop_lighthouseresult_audits['unused-css-rules']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['unused-css-rules']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['unused-css-rules']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['unused-css-rules']['description'])){

											                $unused_css = explode('[',$desktop_lighthouseresult_audits['unused-css-rules']['description']);

											                echo '<p>'.$unused_css[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/unused-css-rules">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['total-byte-weight']['title']))
																    echo $desktop_lighthouseresult_audits['total-byte-weight']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['total-byte-weight']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['total-byte-weight']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['total-byte-weight']['description'])){

											                $total_byte = explode('[',$desktop_lighthouseresult_audits['total-byte-weight']['description']);

											                echo '<p>'.$total_byte[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/total-byte-weight">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['mainthread-work-breakdown']['title']))
																    echo $desktop_lighthouseresult_audits['mainthread-work-breakdown']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['mainthread-work-breakdown']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['mainthread-work-breakdown']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['mainthread-work-breakdown']['description'])){

											                $mainthred_work = explode('[',$desktop_lighthouseresult_audits['mainthread-work-breakdown']['description']);

											                echo '<p>'.$mainthred_work[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/mainthread-work-breakdown">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['uses-webp-images']['title']))
																    echo $desktop_lighthouseresult_audits['uses-webp-images']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['uses-webp-images']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['uses-webp-images']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['uses-webp-images']['description'])){

											                $uses_web_images = explode('[',$desktop_lighthouseresult_audits['uses-webp-images']['description']);

											                echo '<p>'.$uses_web_images[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/uses-webp-images">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['critical-request-chains']['title']))
																    echo $desktop_lighthouseresult_audits['critical-request-chains']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['critical-request-chains']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['critical-request-chains']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['critical-request-chains']['description'])){

											                $critical_request_chains = explode('[',$desktop_lighthouseresult_audits['critical-request-chains']['description']);

											                echo '<p>'.$critical_request_chains[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/critical-request-chains">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['dom-size']['title']))
																    echo $desktop_lighthouseresult_audits['dom-size']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['dom-size']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['dom-size']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['dom-size']['description'])){

											                $dom_size1 = explode('[',$desktop_lighthouseresult_audits['dom-size']['description']);

											                echo '<p>'.$dom_size1[0].'<b><a class="text-danger" target="_BLANK" href="https://developers.google.com/web/fundamentals/performance/rendering/reduce-the-scope-and-complexity-of-style-calculations">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>												
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['redirects']['title']))
																    echo $desktop_lighthouseresult_audits['redirects']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['redirects']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['redirects']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['redirects']['description'])){

											                $redirects_des = explode('[',$desktop_lighthouseresult_audits['redirects']['description']);

											                echo '<p>'.$redirects_des[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/redirects">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['unminified-javascript']['title']))
																    echo $desktop_lighthouseresult_audits['unminified-javascript']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['unminified-javascript']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['unminified-javascript']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['unminified-javascript']['description'])){

											                $unminified_js = explode('[',$desktop_lighthouseresult_audits['unminified-javascript']['description']);

											                echo '<p>'.$unminified_js[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/unminified-javascript">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['user-timings']['title']))
																    echo $desktop_lighthouseresult_audits['user-timings']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['user-timings']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['user-timings']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['user-timings']['description'])){

											                $user_times = explode('[',$desktop_lighthouseresult_audits['user-timings']['description']);

											                echo '<p>'.$user_times[0].'<b><a class="text-danger" target="_BLANK" href="https://web.dev/user-timings">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>													
											<div class="row mt-3">
											    <div class="col-12">
											        <div class="card card-success">
											            <div class="card-header">
											                <h4 class="text-success"><i class="fa fa-check"></i> 
																<?php 
																 if(isset($desktop_lighthouseresult_audits['network-rtt']['title']))
																    echo $desktop_lighthouseresult_audits['network-rtt']['title']; 
																 ?>
											                </h4>
											                <div class="card-header-action">
											                	<code>
											                		<?php 
											                		if(isset($desktop_lighthouseresult_audits['network-rtt']['displayValue']))
											                		echo $desktop_lighthouseresult_audits['network-rtt']['displayValue'];
											                		 ?>
											                	</code>
											                </div>
											            </div>

											            <div class="card-body chart-responsive minus">
														  <?php

											                if(isset($desktop_lighthouseresult_audits['network-rtt']['description'])){

											                $network_rtt = explode('[',$desktop_lighthouseresult_audits['network-rtt']['description']);

											                echo '<p>'.$network_rtt[0].'<b><a class="text-danger" target="_BLANK" href="https://hpbn.co/primer-on-latency-and-bandwidth/">'.__("Learn More").'</a></b></p>';
											                }

											                ?>            
											            </div>
											        </div>
											    </div>
											</div>	
								        </div>
								     </div>
								</div>
							</div>

						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

	</section>

</div>

@include("shared.variables")


<div class="modal fade" id="demo_search" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="fa fa-stethoscope"></i> <?php echo config('settings.product_name'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body clearfix">
                <div class="col-12 text-center" id="domain_success_msg"></div> 
                <div class="col-12 text-center p-4" id="progress_msg">
                    <b><span id="domain_progress_msg_text"></span></b><br/>
                    <div class="progress d-none h-20" id="domain_progress_bar_con"> 
                        <div class="progress-bar progress-bar-info progress-bar-striped progress-bar-animated w-3" aria-valuemax="100" aria-valuemin="0" aria-valuenow="3" role="progressbar"><b><span>1%</span></b></div> 
                    </div>
                </div>              

            </div>
        </div>
    </div>
</div>

<script>
    $j(function($) {
        $(".dial").knob();
    });
</script>

<?php if($load_css_js!=1) { ?>
<script>

	var reportUri = "{{ route('domain.download.report',$site_info->auto_id) }}";
	var fillRequiredfields ='{{ __("Please fill required fields") }}';
	var sentreporttoemail ='{{ route("domain.email.pdf") }}';
	var direct_download="<?php echo $direct_download;?>";
</script>
<script src="{{ asset('assets/js/pages/health-report/download-or-email-site-pdf.js') }}"></script>
<?php } ?>

<script src="{{ asset('assets/js/internal-js/pdf-report.js') }}"></script>

<?php if($is_pdf==0) : ?>
	<script>
		var compare="1";
		var base_site="<?php echo $site_info->id ?? ""; ?>";
		var get_value = "<?php isset($_GET['site']) ? $_GET['site'] : ""; ?>";
		var loaderGif = "{{ asset('assets/images/pre-loader/loading-animations.gif') }}";
		var somethingwentwrong = '<?php echo __('something went wrong, please try again'); ?>';
	</script>

	<script src="{{ asset('assets/js/pages/health-report/check-site-report.js') }}"></script>
<?php endif; ?>

<?php if($compare_report == 0 && $load_css_js==1) echo "</body></html>";?>