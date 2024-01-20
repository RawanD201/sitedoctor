<section id="reports" class="reports-section pt-0 feature-extended-section">
	<div class="feature-extended-wrapper">
		<div class='container'>
		    <?php if(config("settings.advertisement_status")=="1") : ?>
		    	<div class="row">
		    		<div class="col-12">
		    			@if(config("settings.section_1_wide")!='')
		    			<div class="mb-4">{!! config("settings.section_1_wide") !!}</div>
		    			@endif

		    			@if(config("settings.section_1_mobile")!='')
		    			<div class="mb-3">{!! config("settings.section_1_mobile") !!}</div>
		    			@endif
		    		</div>
		    	</div>
			<?php endif ?>
		    <div class="section-title text-center mt-60 mb-60">
	      		<h2 class="mb-25 wow fadeInUp" data-wow-delay=".2s">{{ __("Recent Health Check Report") }}</h2>
		      	<p class="wow fadeInUp" data-wow-delay=".4s">{{ __("Showing Overview of recently checked website health with some data and website screenshot") }}</p>
		    </div>

			<div class="row">
				<div class='col-12'>
					<div class="row">
						<?php foreach($recent_search as $row) {
						        $domain_name_data=strtolower($row->domain_name);
						        $domain_name_data=str_replace(array("www.","http://","https://"), "", $domain_name_data);
						        $details_url=route('domain.report',['site_id'=>$row->id,'site_name'=>$domain_name_data]);
						        $total_words = $row->total_words;
						        $internal_link_count = $row->internal_link_count;
						        $external_link_count = $row->external_link_count;
						        $total_links = $internal_link_count + $external_link_count;
						        $overall_score = $row->overall_score;
						        $searched_at = date("M j, Y", strtotime($row->searched_at));

						        // Desltop Score
						        $desktop_lighthouseresult_audits = json_decode($row->desktop_lighthouseresult_audits,true);
						        $website_screenshot = isset($desktop_lighthouseresult_audits['final-screenshot']['details']['data']) ? $desktop_lighthouseresult_audits['final-screenshot']['details']['data'] : '';

						        $first_meaningful_paint_desktop = isset($desktop_lighthouseresult_audits['first-meaningful-paint']['score']) ? $desktop_lighthouseresult_audits['first-meaningful-paint']['score'] : 0;
						        $speed_index_desktop = isset($desktop_lighthouseresult_audits['speed-index']['score']) ? $desktop_lighthouseresult_audits['speed-index']['score'] : 0;
						        $first_cpu_idle_desktop = isset($desktop_lighthouseresult_audits['first-cpu-idle']['score']) ? $desktop_lighthouseresult_audits['first-cpu-idle']['score'] : 0;
						        $first_contentful_paint_desktop = isset($desktop_lighthouseresult_audits['first-contentful-paint']['score']) ? $desktop_lighthouseresult_audits['first-contentful-paint']['score'] : 0;
						        $interactive_desktop = isset($desktop_lighthouseresult_audits['interactive']['score']) ? $desktop_lighthouseresult_audits['interactive']['score'] : 0;
						        $desktop_score = ($first_meaningful_paint_desktop*7)+($speed_index_desktop*27)+($first_cpu_idle_desktop*13)+($first_contentful_paint_desktop*20)+($interactive_desktop*33);


						        // Mobile score
						        $mobile_lighthouseresult_audits = json_decode($row->mobile_lighthouseresult_audits,true);

						        $first_meaningful_paint_mobile = isset($mobile_lighthouseresult_audits['first-meaningful-paint']['score']) ? $mobile_lighthouseresult_audits['first-meaningful-paint']['score'] : 0;
						        $speed_index_mobile = isset($mobile_lighthouseresult_audits['speed-index']['score']) ? $mobile_lighthouseresult_audits['speed-index']['score'] : 0;
						        $first_cpu_idle_mobile = isset($mobile_lighthouseresult_audits['first-cpu-idle']['score']) ? $mobile_lighthouseresult_audits['first-cpu-idle']['score'] : 0;
						        $first_contentful_paint_mobile = isset($mobile_lighthouseresult_audits['first-contentful-paint']['score']) ? $mobile_lighthouseresult_audits['first-contentful-paint']['score'] : 0;
						        $interactive_mobile = isset($mobile_lighthouseresult_audits['interactive']['score']) ? $mobile_lighthouseresult_audits['interactive']['score'] : 0;

						        $mobile_score = ($first_meaningful_paint_mobile*7)+($speed_index_mobile*27)+($first_cpu_idle_mobile*13)+($first_contentful_paint_mobile*20)+($interactive_mobile*33); 
						?>
						<div class="col-12 col-lg-4 mb-4">
						    <div class="card card-icon-bg-md box-shadow">
						        <a href="{{ route('domain.report',$row->id) }}" target="_blank">
						        	<div class="card-header bg-light-info p-0 domain-screenshot">
						        	    <img src="{{  $website_screenshot ?? asset('assets/images/example-image.jpg') }}" class="border-bottom" alt="" width="100%">
						        	</div>
						        </a>
						        <div class="card-header bg-light-purple p-0 domain-screenshot text-center">
						            <h6 class="card-title text-primary px-4 py-3 m-0" id="domain_name">{!! isset($domain_name_data) ?  __('Summary').': <a class="text-dark fw-normal" href="https://'.$domain_name_data.'" target="_BLANK">'.$domain_name_data.'</a>'   :__("No Domain") !!}
						            </h6>
						        </div>

						        <div class="card-body py-4">
						            <div class="row mb-3">
						                <div class="col">
						                    <div class="d-flex align-items-center">
						                        <div class="symbol symbol-50px me-2">
						                            <div class="symbol-label bg-light-success">
						                                <i class="fas fa-briefcase text-success"></i>
						                            </div>
						                        </div>
						                        <div>
						                            <div class="fs-6 text-dark fw-bold symbol-value"><span id="overallScore"><?php echo $overall_score; ?></span> <sub>/ 100</sub></div>
						                            <div class="fs-6 text-muted symbol-title">{{__('Overall Score')}}</div>
						                        </div>
						                    </div>
						                </div>
						                <div class="col">
						                    <div class="d-flex align-items-center">
						                        <div class="symbol symbol-50px me-2">
						                            <div class="symbol-label bg-light-danger">
						                                <i class="fas fa-desktop text-danger"></i>
						                            </div>
						                        </div>
						                        <div>
						                            <div class="fs-6 text-dark fw-bold symbol-value"><span id="desktopScore"><?php echo $desktop_score; ?></span> <sub>/ 100</sub></div>
						                            <div class="fs-6 text-muted symbol-title">{{__('Desktop Score')}}</div>
						                        </div>
						                    </div>
						                </div>
						            </div>
						            <div class="row mb-3">
						                <div class="col">
						                    <div class="d-flex align-items-center">
						                        <div class="symbol symbol-50px me-2">
						                            <div class="symbol-label bg-light-primary">
						                                <i class="fas fa-mobile text-info"></i>
						                            </div>
						                        </div>
						                        <div>
						                            <div class="fs-6 text-dark fw-bold symbol-value"><span id="mobileScore"><?php echo $mobile_score; ?></span> <sub>/ 100</sub></div>
						                            <div class="fs-6 text-muted symbol-title">{{__('Mobile Score')}}</div>
						                        </div>
						                    </div>
						                </div>
						                <div class="col">
						                    <div class="d-flex align-items-center">
						                        <div class="symbol symbol-50px me-2">
						                            <div class="symbol-label bg-light-warning">
						                                <i class="fas fa-clock text-warning"></i>
						                            </div>
						                        </div>
						                        <div>
						                            <div class="fs-6 text-dark fw-bold symbol-value"><span id="checkedAt"><?php echo $searched_at; ?></span></div>
						                            <div class="fs-6 text-muted symbol-title">{{__('Checked')}}</div>
						                        </div>
						                    </div>
						                </div>
						            </div>
						        </div>
						    </div>
						</div>

						<?php } ?>
					</div>
				</div>

			</div> <!-- end row -->
		</div> <!-- end container -->
	</div> <!-- end feature-extended-wrapper -->
</section> <!-- end section -->