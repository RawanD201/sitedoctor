<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
// use Barryvdh\DomPDF\Facade\Pdf;
// use Dompdf\Dompdf;
use DB;
use PDF;

class Domain extends Home
{

    public function site_health()
    {
        $data['body'] = "domain.site_health";
        $data['load_datatable'] = true;

        return $this->viewcontroller($data);
    }

    public function site_health_data(Request $request)
    {       
        $domain_name = trim(strip_tags($request->domain_name));
        $email = trim(strip_tags($request->email));
        $email_filter = trim(strip_tags($request->email_filter));
        $from_date = trim(strip_tags($request->from_date));
        $to_date = trim(strip_tags($request->to_date));

        // $display_columns = array("#","CHECKBOX",'id', 'domain_name', 'email', 'searched_at','actions');
        $display_columns = array("#",'id','domain_name','email','warning_count','mobile_perfomence_score','actions','desktop_perfomence_score','perfomence_category','overall_score','searched_at');
        $search_columns = array('domain_name', 'email');

        $page = isset($request->page) ? intval($request->page) : 1;
        $start = isset($request->start) ? intval($request->start) : 0;
        $limit = isset($request->length) ? intval($request->length) : 10;
        $sort_index = !is_null($request->input('order.column')) ? strval($request->input('order.column')) : 2;
        $sort = !is_null($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'id';
        $order = !is_null($request->input('order.0.dir')) ? strval($request->input('order.0.dir')) : 'desc';
        $order_by=$sort." ".$order;

        $table="site_check_report";
        $query = DB::table($table);
        $query->leftJoin("site_check_report_partial","site_check_report_partial.site_check_table_id","=","site_check_report.id");

        if($domain_name!=NULL) $query->where("domain_name","like","%".$domain_name."%");
        if($email!=NULL) $query->where("email","like","%".$email."%");
        if($email_filter!=NULL) {
            if($email_filter=="both")
                $query->where("email","!=",NULL);
            else if($email_filter=="only")
                $query->where("email",NULL);
        }

        if($from_date!=NULL) {
            $query->where("searched_at",">=",date("Y-m-d H:i:s",strtotime($from_date)));
        }
        if($to_date!=NULL) {
            $query->where("searched_at","<=",date("Y-m-d H:i:s",strtotime($to_date)));
        }

        $info = $query->orderByRaw($order_by)->offset($start)->limit($limit)->get();

        $query = DB::table($table);

        if($domain_name!=NULL) $query->where("domain_name","like","%".$domain_name."%");
        if($email!=NULL) $query->where("email","like","%".$email."%");
        if($email_filter!=NULL) {
            if($email_filter=="both")
                $query->where("email","!=",NULL);
            else if($email_filter=="only")
                $query->where("email",NULL);
        }

        if($from_date!=NULL) {
            $query->where("searched_at",">=",date("Y-m-d H:i:s",strtotime($from_date)));
        }
        if($to_date!=NULL) {
            $query->where("searched_at","<=",date("Y-m-d H:i:s",strtotime($to_date)));
        }

        $total_result = $query->count();

        foreach ($info as $key => $value) {

            $value->domain_name = "<a target='_BLANK' href='".$value->domain_name."'>".clean_domain_name($value->domain_name)."</a>";
            if($value->email != NULL) {
                $emails_array = explode(',', $value->email);
                $emails = array_unique($emails_array);
                $emails = implode(',', $emails);
                $value->email = '<div data-bs-toggle="tooltip" title="'.__("Click to see email lists").'" data-emails="'.$emails.'"><i class="fas fa-envelope text-success domain_has_emails" style="font-size:20px;cursor:pointer"></i></div>';
            } else {
                $value->email = '<div data-bs-toggle="tooltip" title="'.__("No email").'"><i class="fas fa-envelope text-danger" style="font-size:18px"></i></div>';
            }

            $action_count = 3;
            $site_check_table_id = $value->site_check_table_id ?? 0;
            $value->searched_at = "<div style='min-width:140px;'>".date("M j, Y h:i A",strtotime($value->searched_at))."</div>";
            $report_url = route('domain.report',$site_check_table_id);
            $download_url = route('domain.download.report',$site_check_table_id);

            $value->actions = "<div><a href='".$report_url."' target='_BLANK' class='btn btn-circle btn-outline-primary' data-bs-toggle='tooltip' title='".__("View Report")."'><i class='fas fa-eye'></i></a>";

            $value->actions .= "<a target='_blank' href='".$download_url."' class='btn btn-circle btn-outline-success download_report' table_id='".$site_check_table_id."' data-bs-toggle='tooltip' title='".__("Downaload Report")."'><i class='fas fa-cloud-download-alt'></i></a>";

            $value->actions .= "<a href='#' class='btn btn-circle btn-outline-danger delete_domain' table_id='".$site_check_table_id."' data-bs-toggle='tooltip' title='".__("Delete")."'><i class='fas fa-trash-alt'></i></a></div>";

            $value->actions .="<script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";

        }

        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = array_format_datatable_data($info, $display_columns ,$start);
        echo json_encode($data);
    }

    public function delete_selected_domain(Request $request)
    {
        $domain_ids = $request->domain_ids;

        DB::beginTransaction();
        try {

            DB::table("site_check_report")->whereIn("id",$domain_ids)->delete();
            DB::table("site_check_report_partial")->whereIn("site_check_table_id",$domain_ids)->delete();
            DB::table("comparision")->whereIn("base_site",$domain_ids)->orWhereIn("competutor_site",$domain_ids)->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $error = $e->getMessage();
        }

        echo "1";
    }

    public function delete_domain(Request $request)
    {
        $domain_id = $request->domain_id;

        DB::beginTransaction();
        try {

            DB::table("site_check_report")->where("id",$domain_id)->delete();
            DB::table("site_check_report_partial")->where("site_check_table_id",$domain_id)->delete();
            DB::table("comparision")->where("base_site",$domain_id)->orWhere("competutor_site",$domain_id)->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $error = $e->getMessage();
        }

        echo "1";
    }

    public function comparative_site_health()
    {
        $data['body'] = "domain.comaparative_site_health";
        $data['load_datatable'] = true;

        return $this->viewcontroller($data);
    }

    public function comparative_site_health_data(Request $request)
    {    
        $base_website = trim($request->input("base_website"));
        $competitor_website = trim($request->input("competitor_website"));
        $email_filter = trim(strip_tags($request->email_filter));
        $from_date = trim(strip_tags($request->from_date));
        $to_date = trim(strip_tags($request->to_date));

        $display_columns = array("#",'id','domain_name','email','warning_count','mobile_perfomence_score','actions','desktop_perfomence_score','overall_score','searched_at');
        $search_columns = array('domain_name', 'email');

        $page = isset($request->page) ? intval($request->page) : 1;
        $start = isset($request->start) ? intval($request->start) : 0;
        $limit = isset($request->length) ? intval($request->length) : 10;
        $sort_index = !is_null($request->input('order.column')) ? strval($request->input('order.column')) : 1;
        $sort = !is_null($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'id';
        $order = !is_null($request->input('order.0.dir')) ? strval($request->input('order.0.dir')) : 'desc';
        $order_by=$sort." ".$order;

        $select= array(
            "base_site_table.domain_name as base_domain",
            "competitor_site_table.domain_name as competitor_domain",
            "comparision.base_site",
            "comparision.competutor_site",
            "comparision.searched_at",
            "comparision.email",
            "comparision.id as id",
            "base_site_table.warning_count as base_warning_count",
            "competitor_site_table.warning_count as competitor_warning_count",
            "site_check_report_partial.mobile_perfomence_score as base_mobile_perfomence_score",
            "site_check_report_partial2.mobile_perfomence_score as competitor_mobile_perfomence_score",
            "site_check_report_partial.desktop_perfomence_score as base_desktop_perfomence_score",
            "site_check_report_partial2.desktop_perfomence_score as competitor_desktop_perfomence_score",
            "site_check_report_partial.overall_score as base_overall_score",
            "site_check_report_partial2.overall_score as competitor_overall_score"
        );

        $table="comparision";
        $query = DB::table($table);
        $query = $query->select($select)
                ->leftJoin("site_check_report as base_site_table","comparision.base_site","=","base_site_table.id")
                ->leftJoin("site_check_report_partial","comparision.base_site","=","site_check_report_partial.site_check_table_id")
                ->leftJoin('site_check_report as competitor_site_table','comparision.competutor_site','=','competitor_site_table.id')
                ->leftJoin("site_check_report_partial as site_check_report_partial2","comparision.competutor_site","=","site_check_report_partial2.site_check_table_id");

        if($base_website !=NULL) {
            $query->where("base_site_table.domain_name",'like', "%".$base_website."%");
        }

        if($competitor_website !=NULL) {
            $query->where("base_site_table.domain_name",'like', "%".$competitor_website."%");
        }

        if($email_filter!=NULL) {
            if($email_filter=="both")
                $query->where("comparision.email","!=",NULL);
            else if($email_filter=="only")
                $query->where("comparision.email",NULL);
        }

        if($from_date!=NULL) {
            $query->where("comparision.searched_at",">=",date("Y-m-d H:i:s",strtotime($from_date)));
        }
        if($to_date!=NULL) {
            $query->where("comparision.searched_at","<=",date("Y-m-d H:i:s",strtotime($to_date)));
        }

        $info = $query->orderByRaw($order_by)->offset($start)->limit($limit)->get();

        $query = DB::table($table);
        $query = $query->select($select)->leftJoin("site_check_report as base_site_table","comparision.base_site","=","base_site_table.id")->leftJoin('site_check_report as competitor_site_table','comparision.competutor_site','=','competitor_site_table.id');

        if($base_website !=NULL) {
            $query->where("base_site_table.domain_name",'like', "%".$base_website."%");
        }

        if($competitor_website !=NULL) {
            $query->where("base_site_table.domain_name",'like', "%".$competitor_website."%");
        }

        if($email_filter!=NULL) {
            if($email_filter=="both")
                $query->where("comparision.email","!=",NULL);
            else if($email_filter=="only")
                $query->where("comparision.email",NULL);
        }

        if($from_date!=NULL) {
            $query->where("comparision.searched_at",">=",date("Y-m-d H:i:s",strtotime($from_date)));
        }
        if($to_date!=NULL) {
            $query->where("comparision.searched_at","<=",date("Y-m-d H:i:s",strtotime($to_date)));
        }

        $total_result = $query->count();

        foreach ($info as $key => $value)
        {
            if($value->email != NULL) {
                $emails_array = explode(',', $value->email);
                $emails = array_unique($emails_array);
                $emails = implode(',', $emails);
                $value->email = '<div class="" data-bs-toggle="tooltip" title="'.__("Click to see email lists").'" data-emails="'.$emails.'"><i class="fas fa-envelope text-success domain_has_emails" style="font-size:20px;cursor:pointer"></i></div>';
            } else {
                $value->email = '<div data-bs-toggle="tooltip" title="'.__("No email").'"><i class="fas fa-envelope text-danger" style="font-size:18px"></i></div>';
            }

           $value->id = $value->id;
           $value->domain_name = "<a target='_BLANK' href='".$value->base_domain."'>".clean_domain_name($value->base_domain)."</a> - <a target='_BLANK' href='".$value->competitor_domain."'>".clean_domain_name($value->competitor_domain)."</a>";
           $value->searched_at = date("M j, Y h:i A",strtotime($value->searched_at));
           $value->details = "<a class='label label-warning' href='".route("domain.comparison.report",$value->id)."'><i class='fa fa-file'></i> ".__('report')."</a>";

           $value->warning_count = $value->base_warning_count." - ".$value->competitor_warning_count;            
           $value->mobile_perfomence_score = $value->base_mobile_perfomence_score." - ".$value->competitor_mobile_perfomence_score;            
           $value->desktop_perfomence_score = $value->base_desktop_perfomence_score." - ".$value->competitor_desktop_perfomence_score; 
           $value->overall_score = $value->base_overall_score." - ".$value->competitor_overall_score; 

           $report_url = route("domain.comparison.report",$value->id);
           $download_url = route("domain.download.comparative.report",$value->id);

           $value->actions = "<a href='".$report_url."' target='_BLANK' class='btn btn-circle btn-outline-primary' data-bs-toggle='tooltip' title='".__("View Report")."'><i class='fas fa-eye'></i></a>";
           $value->actions .= "<a target='_blank' href='".$download_url."' class='btn btn-circle btn-outline-success download_report' table_id='".$value->id."' data-bs-toggle='tooltip' title='".__("Downaload Report")."'><i class='fas fa-cloud-download-alt'></i></a>";
           $value->actions .= "<a href='#' class='btn btn-circle btn-outline-danger delete_domain' table_id='".$value->id."' data-bs-toggle='tooltip' title='".__("Delete")."'><i class='fas fa-trash-alt'></i></a>";

           $value->actions .="<script>$('[data-bs-toggle=\"tooltip\"]').tooltip();</script>";
        }

        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = array_format_datatable_data($info, $display_columns ,$start);
        echo json_encode($data);
    }


    public function search_action(Request $request)
    {
        $key=config("settings.google_api_key");
        if($key == '')
        {
            $response=array("status"=>"0","message"=>__('Google API key is not set. Please contact admin about this issue.'));
            echo json_encode($response);
            exit;
        }

        // Session::forget('insert_table_id_sitedoctor');
        // Session::forget('is_compare');
        // Session::forget('compare_table_id');
        // Session::forget('sitedoc_report_completed_for_domain');

        $domain=trim($request->website);
        if($domain=="")
        {
            $response=array("status"=>"0","message"=>__('you have not enter any domain name'));
            echo json_encode($response);
            exit();
        }

        $domain=url_add_http($domain);       
        $domain_encoded=url_convert_to_ascii($domain);
        $base_site=trim($request->base_site);
        $compare=trim($request->compare);

        $download_id=session('download_id_front');

        $insert=array();

        $insert["domain_name"]=$domain;
        $insert["searched_at"]=date("Y-m-d H:i:s");
        $insert["completed_step_count"]=0;

        $search_existing_info = DB::table("site_check_report")->select("id")->where("domain_name",$domain)->get();
        if($search_existing_info->isEmpty())
        {
            DB::table("site_check_report")->insert($insert);
            $last_id=DB::getPdo()->lastInsertId(); 
        }
        else
        {
            DB::table("site_check_report")->where(['id'=>$search_existing_info[0]->id])->update($insert);
            $last_id = $search_existing_info[0]->id;            
        }
        //***************************************//  

        // session(['insert_table_id_sitedoctor'=> $last_id]);
        // session(['health_check_total'=>100]);
        session(['health_check_count'=>0]);
        // session(['sitedoc_report_completed_for_domain'=>$domain]);

        if($compare==1)
        {
            $insert_compare=array();
            $insert_compare["searched_at"]=date("Y-m-d H:i:s");
            $insert_compare["base_site"]=$base_site;
            $insert_compare["competutor_site"]=$last_id;
            $insert_compare["email"]='';
            DB::table("comparision")->insert($insert_compare);
            $comparision_id=DB::getPdo()->lastInsertId();
            // session(['compare_table_id'=>$comparision_id]);
            // session(['is_compare'=>'1']);
        }
        else
            session(['is_compare'=>'0']);

        session_write_close();

        // site check starts [36 steps calculated here]
        $site_stat=site_statistic_check($domain_encoded);
        $step_count=session('health_check_count');
        if($step_count=="") $step_count=0;
        $insert['completed_step_count'] = $step_count;
        DB::table("site_check_report")->where("id",$last_id)->update($insert);

        $domain_ip = '';
        foreach ($site_stat as $key => $value) 
        {
            if($key == 'ip') $domain_ip = $value;
            $insert[$key]= is_array($value) ? json_encode($value) : $value;
        }
        // end of site check


        //desktop starts
        $step_count+=8;
        $insert['completed_step_count'] = $step_count;
        DB::table("site_check_report")->where("id",$last_id)->update($insert);
        

        // initialize $insert variable to empty so that it can be used to insert in different table
        $partial_table_insert = [];
        $partial_table_insert['site_check_table_id'] = $last_id;
        $partial_table_info = DB::table("site_check_report_partial")->select("id")->where("site_check_table_id",$last_id)->get();
        if($partial_table_info->isEmpty())
        {
            $partial_table_insert['email'] = '';
            DB::table("site_check_report_partial")->insert($partial_table_insert);
            $partial_table_id=DB::getPdo()->lastInsertId(); 
        }
        else
        {
            DB::table("site_check_report_partial")->where(['id'=>$partial_table_info[0]->id])->update($partial_table_insert);
            $partial_table_id = $partial_table_info[0]->id;            
        }

        $desktop_result=google_page_speed_insight_desktop($domain,"desktop");

        // score calculation link: https://googlechrome.github.io/lighthouse/scorecalc/#FCP=3000&SI=5800&FMP=4000&TTI=7300&FCI=6500&LCP=4000&TBT=600&CLS=0.25&device=desktop&version=8

            
        if (isset($desktop_result['error'])) {
            $partial_table_insert['desktop_google_api_error'] = $desktop_result['error']['message'];
        }
        else{

            if (isset($desktop_result['loadingExperience'])) {
                $partial_table_insert["desktop_loadingexperience_metrics"] =  isset($desktop_result['loadingExperience']) ? json_encode($desktop_result['loadingExperience']) : "";
            }
            if (isset($desktop_result['originLoadingExperience'])) {
                $partial_table_insert["desktop_originloadingexperience_metrics"] =  isset($desktop_result['originLoadingExperience']) ? json_encode($desktop_result['originLoadingExperience']) : "";
            }
            if (isset($desktop_result['lighthouseResult']['configSettings'])) {
               $partial_table_insert["desktop_lighthouseresult_configsettings"] =  isset($desktop_result['lighthouseResult']['configSettings']) ? json_encode($desktop_result['lighthouseResult']['configSettings']) : "";
            }
            if (isset($desktop_result['lighthouseResult']['audits'])) {

                $first_meaningful_paint = isset($desktop_result['lighthouseResult']['audits']['first-meaningful-paint']['score']) ? $desktop_result['lighthouseResult']['audits']['first-meaningful-paint']['score'] : 0;
                
                $largest_contentful_paint_element = isset($desktop_result['lighthouseResult']['audits']['largest-contentful-paint-element']['score']) ? $desktop_result['lighthouseResult']['audits']['largest-contentful-paint-element']['score'] : 0;

                $speed_index = isset($desktop_result['lighthouseResult']['audits']['speed-index']['score']) ? 
                $desktop_result['lighthouseResult']['audits']['speed-index']['score'] : 0;

                $first_cpu_idle = isset($desktop_result['lighthouseResult']['audits']['first-cpu-idle']['score']) ? $desktop_result['lighthouseResult']['audits']['first-cpu-idle']['score'] : 0;
                
                $total_blocking_time = isset($desktop_result['lighthouseResult']['audits']['total-blocking-time']['score']) ? $desktop_result['lighthouseResult']['audits']['total-blocking-time']['score'] : 0;

                $first_contentful_paint = isset($desktop_result['lighthouseResult']['audits']['first-contentful-paint']['score']) ? $desktop_result['lighthouseResult']['audits']['first-contentful-paint']['score'] : 0;
                
                $time_to_Interactive = isset($desktop_result['lighthouseResult']['audits']['interactive']['score']) ? $desktop_result['lighthouseResult']['audits']['interactive']['score'] : 0;
                
                $cumulative_layout_shift = isset($desktop_result['lighthouseResult']['audits']['cumulative-layout-shift']['score']) ? $desktop_result['lighthouseResult']['audits']['cumulative-layout-shift']['score'] : 0;

                $desktop_score = ($first_contentful_paint*10)+($speed_index*10)+($largest_contentful_paint_element*25)+($time_to_Interactive*10)+($total_blocking_time*30)+($cumulative_layout_shift*15);

                $partial_table_insert["desktop_perfomence_score"] = $desktop_score;

                if(isset($desktop_result['lighthouseResult']['audits']['resource-summary']))
                    unset($desktop_result['lighthouseResult']['audits']['resource-summary']['details']);

                if (isset($desktop_result['lighthouseResult']['audits']['efficient-animated-content']))
                    unset($desktop_result['lighthouseResult']['audits']['efficient-animated-content']['details']);

                if (isset($desktop_result['lighthouseResult']['audits']['metrics']))
                    unset($desktop_result['lighthouseResult']['audits']['metrics']);   

                if (isset($desktop_result['lighthouseResult']['audits']['network-server-latency']))
                    unset($desktop_result['lighthouseResult']['audits']['network-server-latency']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['offscreen-images']))
                    unset($desktop_result['lighthouseResult']['audits']['offscreen-images']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['uses-responsive-images']))
                    unset($desktop_result['lighthouseResult']['audits']['uses-responsive-images']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['unused-css-rules']))
                    unset($desktop_result['lighthouseResult']['audits']['unused-css-rules']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['total-byte-weight']))
                    unset($desktop_result['lighthouseResult']['audits']['total-byte-weight']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['mainthread-work-breakdown']))
                    unset($desktop_result['lighthouseResult']['audits']['mainthread-work-breakdown']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['uses-webp-images']))
                    unset($desktop_result['lighthouseResult']['audits']['uses-webp-images']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['critical-request-chains']))
                    unset($desktop_result['lighthouseResult']['audits']['critical-request-chains']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['dom-size']))
                    unset($desktop_result['lighthouseResult']['audits']['dom-size']['details']);                

                if (isset($desktop_result['lighthouseResult']['audits']['unminified-javascript']))
                    unset($desktop_result['lighthouseResult']['audits']['unminified-javascript']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['redirects']))
                    unset($desktop_result['lighthouseResult']['audits']['redirects']['details']);   

                if (isset($desktop_result['lighthouseResult']['audits']['time-to-first-byte']))
                    unset($desktop_result['lighthouseResult']['audits']['time-to-first-byte']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['render-blocking-resources']))
                    unset($desktop_result['lighthouseResult']['audits']['render-blocking-resources']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['font-display']))
                    unset($desktop_result['lighthouseResult']['audits']['font-display']['details']);

                if (isset($desktop_result['lighthouseResult']['audits']['estimated-input-latency']))
                    unset($desktop_result['lighthouseResult']['audits']['estimated-input-latency']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['uses-rel-preconnect']))
                    unset($desktop_result['lighthouseResult']['audits']['uses-rel-preconnect']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['unminified-css']))
                    unset($desktop_result['lighthouseResult']['audits']['unminified-css']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['bootup-time']))
                    unset($desktop_result['lighthouseResult']['audits']['bootup-time']['details']);                

                if (isset($desktop_result['lighthouseResult']['audits']['uses-rel-preload']))
                    unset($desktop_result['lighthouseResult']['audits']['uses-rel-preload']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['user-timings']))
                    unset($desktop_result['lighthouseResult']['audits']['user-timings']['details']);                

                if (isset($desktop_result['lighthouseResult']['audits']['uses-text-compression']))
                    unset($desktop_result['lighthouseResult']['audits']['uses-text-compression']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['uses-optimized-images']))
                    unset($desktop_result['lighthouseResult']['audits']['uses-optimized-images']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['uses-long-cache-ttl']))
                    unset($desktop_result['lighthouseResult']['audits']['uses-long-cache-ttl']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['third-party-summary']))
                    unset($desktop_result['lighthouseResult']['audits']['third-party-summary']['details']);                
                if (isset($desktop_result['lighthouseResult']['audits']['network-rtt']))
                    unset($desktop_result['lighthouseResult']['audits']['network-rtt']['details']);                

                if (isset($desktop_result['lighthouseResult']['audits']['diagnostics']))
                    unset($desktop_result['lighthouseResult']['audits']['diagnostics']);                

                if (isset($desktop_result['lighthouseResult']['audits']['network-requests']))
                    unset($desktop_result['lighthouseResult']['audits']['network-requests']['details']);                

                if (isset($desktop_result['lighthouseResult']['audits']['screenshot-thumbnails']))
                    unset($desktop_result['lighthouseResult']['audits']['screenshot-thumbnails']);                

                if (isset($desktop_result['lighthouseResult']['audits']['main-thread-tasks']))
                    unset($desktop_result['lighthouseResult']['audits']['main-thread-tasks']);

                if (isset($desktop_result['lighthouseResult']['categories']['performance']))
                    unset($desktop_result['lighthouseResult']['categories']['performance']['auditRefs']);                
                
                $partial_table_insert['desktop_lighthouseresult_audits'] = isset($desktop_result['lighthouseResult']['audits']) ? json_encode($desktop_result['lighthouseResult']['audits']) : "";                   

            }
            if (isset($desktop_result['lighthouseResult']['categories'])) {
                $partial_table_insert['desktop_lighthouseresult_categories'] = isset($desktop_result['lighthouseResult']['categories']) ? json_encode($desktop_result['lighthouseResult']['categories']) : "";
            }
        }
            
        
        $step_count+=8;
        $insert['completed_step_count'] = $step_count;
        DB::table("site_check_report")->where("id",$last_id)->update($insert);
        DB::table("site_check_report_partial")->where("site_check_table_id",$last_id)->update($partial_table_insert);
        // end of desktop


        // unset Desktop Information 

        unset($partial_table_insert['desktop_lighthouseresult_categories']);
        unset($partial_table_insert['desktop_lighthouseresult_audits']);
        unset($partial_table_insert['desktop_google_api_error']);
        unset($partial_table_insert['desktop_loadingexperience_metrics']);
        unset($partial_table_insert['desktop_originloadingexperience_metrics']);
        unset($partial_table_insert['desktop_lighthouseresult_configsettings']);
        unset($partial_table_insert['desktop_perfomence_score']);
        unset($partial_table_insert['desktop_perfomence_score']);


        // mobile starts
        $mobile_result=google_page_speed_insight_mobile($domain,"mobile");

        $step_count+=16;
        $insert['completed_step_count'] = $step_count;
        DB::table("site_check_report")->where("id",$last_id)->update($insert);

        if (isset($mobile_result['error'])) {
            $partial_table_insert['mobile_google_api_error'] = $mobile_result['error']['message'];
        }
        else{
            if (isset($mobile_result['loadingExperience'])) {
                $partial_table_insert["mobile_loadingexperience_metrics"] =  isset($mobile_result['loadingExperience']) ? json_encode($mobile_result['loadingExperience']) : "";
            }
            if (isset($mobile_result['originLoadingExperience'])) {
                $partial_table_insert["mobile_originloadingexperience_metrics"] =  isset($mobile_result['originLoadingExperience']) ? json_encode($mobile_result['originLoadingExperience']) : "";
            }
            if (isset($mobile_result['lighthouseResult']['configSettings'])) {
               $partial_table_insert["mobile_lighthouseresult_configsettings"] =  isset($mobile_result['lighthouseResult']['configSettings']) ? json_encode($mobile_result['lighthouseResult']['configSettings']) : "";
            }
            if (isset($mobile_result['lighthouseResult']['audits'])) {
                
                $largest_contentful_paint_element1 = isset($mobile_result['lighthouseResult']['audits']['largest-contentful-paint-element']['score']) ? $mobile_result['lighthouseResult']['audits']['largest-contentful-paint-element']['score'] : 0;

                $speed_index1 = isset($mobile_result['lighthouseResult']['audits']['speed-index']['score']) ? 
                $mobile_result['lighthouseResult']['audits']['speed-index']['score'] : 0;
                
                $total_blocking_time1 = isset($mobile_result['lighthouseResult']['audits']['total-blocking-time']['score']) ? $mobile_result['lighthouseResult']['audits']['total-blocking-time']['score'] : 0;

                $first_contentful_paint1 = isset($mobile_result['lighthouseResult']['audits']['first-contentful-paint']['score']) ? $mobile_result['lighthouseResult']['audits']['first-contentful-paint']['score'] : 0;
                
                $time_to_Interactive1 = isset($mobile_result['lighthouseResult']['audits']['interactive']['score']) ? $mobile_result['lighthouseResult']['audits']['interactive']['score'] : 0;
                
                $cumulative_layout_shift1 = isset($mobile_result['lighthouseResult']['audits']['cumulative-layout-shift']['score']) ? $mobile_result['lighthouseResult']['audits']['cumulative-layout-shift']['score'] : 0;

                $mobile_score = ($first_contentful_paint1*10)+($speed_index1*10)+($largest_contentful_paint_element1*25)+($time_to_Interactive1*10)+($total_blocking_time1*30)+($cumulative_layout_shift1*15);


                $partial_table_insert["mobile_perfomence_score"] = $mobile_score;

                if(isset($mobile_result['lighthouseResult']['audits']['resource-summary']))
                    unset($mobile_result['lighthouseResult']['audits']['resource-summary']['details']);

                if (isset($mobile_result['lighthouseResult']['audits']['efficient-animated-content']))
                    unset($mobile_result['lighthouseResult']['audits']['efficient-animated-content']['details']);

                if (isset($mobile_result['lighthouseResult']['audits']['metrics']))
                    unset($mobile_result['lighthouseResult']['audits']['metrics']);   

                if (isset($mobile_result['lighthouseResult']['audits']['network-server-latency']))
                    unset($mobile_result['lighthouseResult']['audits']['network-server-latency']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['offscreen-images']))
                    unset($mobile_result['lighthouseResult']['audits']['offscreen-images']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['uses-responsive-images']))
                    unset($mobile_result['lighthouseResult']['audits']['uses-responsive-images']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['unused-css-rules']))
                    unset($mobile_result['lighthouseResult']['audits']['unused-css-rules']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['total-byte-weight']))
                    unset($mobile_result['lighthouseResult']['audits']['total-byte-weight']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['mainthread-work-breakdown']))
                    unset($mobile_result['lighthouseResult']['audits']['mainthread-work-breakdown']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['uses-webp-images']))
                    unset($mobile_result['lighthouseResult']['audits']['uses-webp-images']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['critical-request-chains']))
                    unset($mobile_result['lighthouseResult']['audits']['critical-request-chains']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['dom-size']))
                    unset($mobile_result['lighthouseResult']['audits']['dom-size']['details']);                

                if (isset($mobile_result['lighthouseResult']['audits']['unminified-javascript']))
                    unset($mobile_result['lighthouseResult']['audits']['unminified-javascript']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['redirects']))
                    unset($mobile_result['lighthouseResult']['audits']['redirects']['details']);   

                if (isset($mobile_result['lighthouseResult']['audits']['time-to-first-byte']))
                    unset($mobile_result['lighthouseResult']['audits']['time-to-first-byte']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['render-blocking-resources']))
                    unset($mobile_result['lighthouseResult']['audits']['render-blocking-resources']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['font-display']))
                    unset($mobile_result['lighthouseResult']['audits']['font-display']['details']);

                if (isset($mobile_result['lighthouseResult']['audits']['estimated-input-latency']))
                    unset($mobile_result['lighthouseResult']['audits']['estimated-input-latency']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['uses-rel-preconnect']))
                    unset($mobile_result['lighthouseResult']['audits']['uses-rel-preconnect']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['unminified-css']))
                    unset($mobile_result['lighthouseResult']['audits']['unminified-css']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['bootup-time']))
                    unset($mobile_result['lighthouseResult']['audits']['bootup-time']['details']);                

                if (isset($mobile_result['lighthouseResult']['audits']['uses-rel-preload']))
                    unset($mobile_result['lighthouseResult']['audits']['uses-rel-preload']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['user-timings']))
                    unset($mobile_result['lighthouseResult']['audits']['user-timings']['details']);                

                if (isset($mobile_result['lighthouseResult']['audits']['uses-text-compression']))
                    unset($mobile_result['lighthouseResult']['audits']['uses-text-compression']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['uses-optimized-images']))
                    unset($mobile_result['lighthouseResult']['audits']['uses-optimized-images']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['uses-long-cache-ttl']))
                    unset($mobile_result['lighthouseResult']['audits']['uses-long-cache-ttl']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['third-party-summary']))
                    unset($mobile_result['lighthouseResult']['audits']['third-party-summary']['details']);                
                if (isset($mobile_result['lighthouseResult']['audits']['network-rtt']))
                    unset($mobile_result['lighthouseResult']['audits']['network-rtt']['details']);                

                if (isset($mobile_result['lighthouseResult']['audits']['diagnostics']))
                    unset($mobile_result['lighthouseResult']['audits']['diagnostics']);                

                if (isset($mobile_result['lighthouseResult']['audits']['network-requests']))
                    unset($mobile_result['lighthouseResult']['audits']['network-requests']['details']);                

                if (isset($mobile_result['lighthouseResult']['audits']['screenshot-thumbnails']))
                    unset($mobile_result['lighthouseResult']['audits']['screenshot-thumbnails']);                

                if (isset($mobile_result['lighthouseResult']['audits']['main-thread-tasks']))
                    unset($mobile_result['lighthouseResult']['audits']['main-thread-tasks']);

                if (isset($mobile_result['lighthouseResult']['categories']['performance']))
                    unset($mobile_result['lighthouseResult']['categories']['performance']['auditRefs']);                
                
                $partial_table_insert['mobile_lighthouseresult_audits'] = isset($mobile_result['lighthouseResult']['audits']) ? json_encode($mobile_result['lighthouseResult']['audits']) : "";                   

            }
            if (isset($mobile_result['lighthouseResult']['categories'])) {
                $partial_table_insert['mobile_lighthouseresult_categories'] = isset($mobile_result['lighthouseResult']['categories']) ? json_encode($mobile_result['lighthouseResult']['categories']) : "";
            }
        }
        // end of mobile

        $partial_table_insert["perfomence_category"] = "Performance";
        $step_count+=15;
        $insert['completed_step_count'] = $step_count;
        DB::table("site_check_report")->where("id",$last_id)->update($insert);
        DB::table("site_check_report_partial")->where("site_check_table_id",$last_id)->update($partial_table_insert);

        // unset mobile information
        unset($partial_table_insert['mobile_loadingexperience_metrics']);
        unset($partial_table_insert['mobile_originloadingexperience_metrics']);
        unset($partial_table_insert['mobile_lighthouseresult_configsettings']);
        unset($partial_table_insert['mobile_perfomence_score']);
        unset($partial_table_insert['mobile_lighthouseresult_audits']);
        unset($partial_table_insert['mobile_lighthouseresult_categories']);
        unset($partial_table_insert['mobile_google_api_error']);

        $partial_table_insert["alexa_rank"] = json_encode(get_alexa_rank($domain));
        $partial_table_insert["domain_ip_info"] = json_encode(get_ip_country($domain_ip,$proxy=''));

        $step_count+=15;
        $insert['completed_step_count'] = $step_count;
        DB::table("site_check_report")->where("id",$last_id)->update($insert);
        DB::table("site_check_report_partial")->where("site_check_table_id",$last_id)->update($partial_table_insert);

        $all_scores = array();

        $all_scores['page_title'] = $insert['title'];
        $all_scores['meta_description'] = $insert['description'];
        $all_scores['text_html_ratio'] = $insert['text_to_html_ratio'];
        $all_scores['robot_txt'] = $insert['robot_txt_exist'];
        $all_scores['sitemap_exist'] = $insert['sitemap_exist'];
        $all_scores['is_favicon_found'] = $insert['is_favicon_found'];
        $all_scores['image_without_alt_count'] = $insert['image_without_alt_count'];
        $all_scores['doctype_is_exist'] = $insert['doctype_is_exist'];
        $depreciated_html_tag=json_decode($insert["depreciated_html_tag"],true);
        $depreciated_html_tag=array_sum($depreciated_html_tag);       
        $all_scores['depreciated_html_tag'] = $depreciated_html_tag;
        $all_scores['total_page_size_general']=round($insert["total_page_size_general"]);
        $all_scores['page_size_gzip'] = round($insert["page_size_gzip"]);

        $inline_css=json_decode($insert["inline_css"],true);
        $inline_css=count($inline_css);
        $all_scores['inline_css'] = $inline_css;

        $internal_css=json_decode($insert["internal_css"],true);
        $internal_css=count($internal_css);
        $all_scores['internal_css'] = $internal_css;

        $micro_data_schema_list=json_decode($insert["micro_data_schema_list"],true);
        $micro_data_schema_list=count($micro_data_schema_list);       
        $all_scores['micro_data_schema_list'] = $micro_data_schema_list;

        $all_scores['is_ip_canonical'] = $insert["is_ip_canonical"];

        $all_scores['is_url_canonicalized'] = $insert["is_url_canonicalized"];

        $email_list=json_decode($insert["email_list"],true);
        $email_list=count($email_list);
        $all_scores['email_list'] = $email_list;

        $meta_keyword=$insert["meta_keyword"];
        $meta_keyword_check=empty($meta_keyword) ? 1 : 0;
        $all_scores['meta_keyword'] = $meta_keyword_check;

        $one_phrase=json_decode($insert["keyword_one_phrase"],true); 
        $two_phrase=json_decode($insert["keyword_two_phrase"],true); 
        $three_phrase=json_decode($insert["keyword_three_phrase"],true); 
        $four_phrase=json_decode($insert["keyword_four_phrase"],true); 

        $keyword_usage=keyword_usage_check($insert["meta_keyword"],array_keys($one_phrase),array_keys($two_phrase),array_keys($three_phrase),array_keys($four_phrase));
        $all_scores['keyword_usage'] = $keyword_usage;

        $not_seo_friendly_link=json_decode($insert["not_seo_friendly_link"],true);
        $not_seo_friendly_link=count($not_seo_friendly_link);
        $all_scores['not_seo_friendly_link'] = $not_seo_friendly_link;

        $all_scores['html_headings']=0;
        $h1=json_decode($insert["h1"],true); 
        if(count($h1) > 0) {
            $all_scores['html_headings']+=0.5;
        }
        $h2=json_decode($insert["h2"],true); 
        if(count($h2) > 0) {
            $all_scores['html_headings']+=0.2;
        }
        $h3=json_decode($insert["h3"],true); 
        if(count($h3) > 0) {
            $all_scores['html_headings']+=0.2;
        }
        $h4=json_decode($insert["h4"],true); 
        if(count($h4) > 0) {
            $all_scores['html_headings']+=0.2;
        }
        $h5=json_decode($insert["h5"],true); 
        if(count($h5) > 0) {
            $all_scores['html_headings']+=0.2;
        }
        $h6=json_decode($insert["h6"],true);  
        if(count($h6) > 0) {
            $all_scores['html_headings']+=0.2;
        }        

        $partial_table_insert["overall_score"] = get_overall_score($all_scores);
        

        $step_count++;
        $insert['completed_step_count'] = $step_count;
        DB::table("site_check_report")->where("id",$last_id)->update($insert);
        DB::table("site_check_report_partial")->where("site_check_table_id",$last_id)->update($partial_table_insert);

        if($compare==1) {
            $details_url=route('domain.comparison.report',$comparision_id);
        }
        else {
            $details_url=route('domain.report',['site_id'=>$last_id,'site_name'=>clean_domain_name($domain)]);
        }

        $response=array("status"=>"1","details_url"=>$details_url);

        echo json_encode($response);
    }

    public function progress_count(Request $request)
    {
        $comparision_id=trim($request->base_site);
        $domain=trim($request->website);
        $is_compare=trim($request->compare);
        $domain=url_add_http($domain);
        $bulk_tracking_total_search= 100; 

        $bulk_complete_search = 0;
        $info = DB::table("site_check_report")->select(["completed_step_count",'id'])->where("domain_name",$domain)->get();

        $insert_table_id = isset($info[0]->id) ? $info[0]->id : 0;
        $bulk_complete_search=isset($info[0]->completed_step_count) ? (int)$info[0]->completed_step_count : 0;

        $response['details_url'] = 'not_set';
        $link = '';
        if($is_compare == '1')
        {
            if($comparision_id != '')
            {              
                $link = route('domain.comparison.report',$comparision_id);
            }
        }
        if($is_compare == '0')
        {
            if($insert_table_id != '')
            {   
                $link = route('domain.report',['site_id'=>$insert_table_id,'site_name'=>clean_domain_name($domain)]);;
            }
        }
        if($link != '') $response['details_url'] = $link;  
        $response['search_complete']=$bulk_complete_search;
        $response['search_total']=$bulk_tracking_total_search;   
        $response['site_name']=$domain;   

        echo json_encode($response);        
    }

    public function report($id=0,$domain="")
    {
       if($id==0) abort(403);
       $data["site_info"] = DB::table("site_check_report")->select('site_check_report.*','site_check_report_partial.*','site_check_report.id as auto_id')->where('site_check_report.id',$id)->leftJoin("site_check_report_partial","site_check_report_partial.site_check_table_id","=","site_check_report.id")->first();

       if(!empty($data["site_info"])) 
        $page_title= strtolower($data["site_info"]->domain_name);
       else abort(403);

       $data["page_title"]=str_replace(array("www.","http://","https://"), "", $page_title);

       $data['seo_meta_description']= __("web site healthy check report of") ." ".$page_title." by ".config("settings.product_name");
       $data["load_css_js"]=0;
       $data["is_pdf"]=0;
       $data["compare_report"]=0;
       $data["body"]="domain.pdf_report";
       $data['direct_download'] = 1;
       if(config("settings.collect_visitor_email")=="1") 
            $data['direct_download'] = 0;

       $data["recommendations"]=$this->recommendations();
       $data["spam_keywords"]=$this->spam_keywords();

       return $this->siteviewcontroller($data);
    }

    public function send_download_link(Request $request)
    {
        $name = trim($request->name);
        $email = trim($request->email);
        $id = trim($request->hidden_id);
        $lead_config = config("settings");

        if(is_array($lead_config)) {
          $allowed_download_per_email=$lead_config["report_download_limit"];
          $unlimited_download_emails=$lead_config["unlimited_report_access"];
        }
        else
        {
          $allowed_download_per_email=10;  
          $unlimited_download_emails="";
        }
        
        $unlimited_download_emails=explode(',',$unlimited_download_emails);
        $data=array("firstname"=>$name,"email"=>$email);

        $where['where'] = array('id'=>$id);
        $data["site_info"] = DB::table("site_check_report")->where('id',$id)->first();
        $domain="";
        if(isset($data["site_info"])) $domain= strtolower($data["site_info"]->domain_name);
        $domain=str_replace(array("www.","http://","https://"), "", $domain);  

        $ret_val="1";
        $response = [];
        
        if(DB::table("leads")->select("id")->where("email",$email)->where("no_of_search",">=",$allowed_download_per_email)->exists())
        {
          if(!in_array($email,$unlimited_download_emails)) {
            $ret_val= "0"; // crossed limit
            $response['error'] = true;
            $response['message'] = __("you can not download more result using this email, download quota is crossed");
            return response()->json($response);
          }
        }


        if($ret_val=="1")
        {    
            $sql2 = "UPDATE site_check_report_partial SET email=trim(both ',' from concat(email, ', ".$email."')) WHERE site_check_table_id=".$id;
            $test = DB::update($sql2);
            
            if(DB::table("leads")->select("id")->where("email",$email)->exists())
            {
                $sql = "UPDATE leads SET name='".$name."',no_of_search=no_of_search+1,domain=trim(both ',' from concat(domain, ', ".$domain."')),date_time='".date("Y-m-d H:i:s")."' WHERE email='".$email."'";
                DB::update($sql);
                   
            }
            else 
            {
                DB::table("leads")->insert(array("name"=>$name,"domain"=>$domain,"email"=>$email,"no_of_search"=>1,"date_time"=>date("Y-m-d H:i:s")));
                syncMailchimp($data);
            }


            $response['error'] = false;
            $product = config('settings.product_name');
            $subject = $product." | ".__('Health Check Report')." : ".$domain;

            $download_link="<a href='".route('domain.download.report',$id)."'> health check report of ".$domain."</a>";
            $message="Hello {$name}, <br/> Thank you for using {$product}.<br/> Please follow the link to download report: {$download_link}<br/><br/><br/>{$product} Team";

            $this->send_email($email,$message,$subject);
            $response['message'] = __('An email with download link has sent to your email address. Please check.');
            
        }   
     

        return response()->json($response);
    }
    

    public function report_pdf($id=0,$domain="")
    {
       if($id==0) exit();

       $site_info = DB::table("site_check_report")->select('site_check_report.*','site_check_report_partial.*','site_check_report.id as auto_id')->where('site_check_report.id',$id)->leftJoin("site_check_report_partial","site_check_report_partial.site_check_table_id","=","site_check_report.id")->first();

       $data['site_info'] = $site_info;

       if(isset($site_info)) $page_title= strtolower($site_info->domain_name);
       else exit();


       $page_title = str_replace(array("www.","http://","https://"), "", $page_title);   

       $desireLogoPath = storage_path('app/public/assets/logo');
       $desireFavPath = storage_path('app/public/assets/favicon');
       $data['logo'] = (file_exists($desireLogoPath) && !empty(File::files($desireLogoPath))) ? File::files($desireLogoPath)[0]->getFilename(): "";
       $data['favicon'] = (file_exists($desireFavPath) && !empty(File::files($desireFavPath))) ? File::files($desireFavPath)[0]->getFilename(): "";    

       $data["site_info"]=$site_info;
       $data["page_title"]=$page_title;
       $data["load_css_js"]=1;
       $data["compare"]=0;
       $data["compare_report"]=0;
       $data["is_pdf"]=1;
       $data["recommendations"]=$this->recommendations();
       $data["spam_keywords"]=$this->spam_keywords();


        $pdf = PDF::loadView('domain.download_pdf_report', $data, [], [
           'auto_language_detection' => true,
           'format' => 'Legal',
        ])->save(storage_path('app/public/download/'.$id.'.pdf'));

        $url = url(asset('storage/app/public/download/'.$id.'.pdf'));

        header("Content-type:application/pdf");
        // It will be called downloaded.pdf
        header("Content-Disposition:attachment;filename=".$id.".pdf");
        // The PDF source is in original.pdf
        readfile($url);
       
    }


    public function comparison_report($id=0)
    {
       if($id==0) exit();

       $where = array('comparision.id'=>$id);
       $select=array("comparision.base_site","comparision.competutor_site","comparision.searched_at","comparision.id as id");
       $data["comparision_info"] = DB::table("comparision")->where($where)->select($select)->get();

       if(!isset($data["comparision_info"][0])) exit();    

       $where = array('site_check_report.id'=>$data["comparision_info"][0]->base_site);
       $data["site_info"] = DB::table("site_check_report")->where($where)->leftJoin("site_check_report_partial","site_check_report_partial.site_check_table_id","=","site_check_report.id")->get();
       if(!isset($data["site_info"][0])) exit();

       $where = array('site_check_report.id'=>$data["comparision_info"][0]->competutor_site);
       $data["site_info2"] = DB::table("site_check_report")->where($where)->leftJoin("site_check_report_partial","site_check_report_partial.site_check_table_id","=","site_check_report.id")->get();
       if(!isset($data["site_info2"][0])) exit();
    

       $data["comparision_info"][0]->base_domain = $data["site_info"][0]->domain_name;
       $data["comparision_info"][0]->competutor_domain=$data["site_info2"][0]->domain_name;
       $page_title= strtolower($data["comparision_info"][0]->base_domain)." Vs ".strtolower($data["comparision_info"][0]->competutor_domain);

       $page_title=str_replace(array("www.","http://","https://"), "", $page_title);
       $data["page_title"]=$page_title;       
       $data['seo_meta_description']="web site healthy check report of ".$page_title." by ".config("settings.product_name");

       $data["load_css_js"]=0;
       $data["is_pdf"]=0;
       $data["compare_report"]=1;

       $data['direct_download'] = 1;
        if(config("settings.collect_visitor_email")=="1") 
            $data['direct_download'] = 0;


       $data["body"]="domain.comparison_report";
       $data["recommendations"]=$this->recommendations();
       $data["spam_keywords"]=$this->spam_keywords();

       return $this->siteviewcontroller($data);
    }



    public function comparision_report_pdf($id=0)
    {
       if($id==0) exit();
     
       $where = array('comparision.id'=>$id);
       $select=array("comparision.base_site","comparision.competutor_site","comparision.searched_at","comparision.id as id");
       $data["comparision_info"] = DB::table("comparision")->select($select)->where($where)->get();
       if(!isset($data["comparision_info"][0])) exit();
       
       $where = array('site_check_report.id'=>$data["comparision_info"][0]->base_site);
       $data["site_info"] = DB::table("site_check_report")->where($where)->leftJoin("site_check_report_partial","site_check_report_partial.site_check_table_id","=","site_check_report.id")->get();
       if(!isset($data["site_info"][0])) exit();

       $where = array('site_check_report.id'=>$data["comparision_info"][0]->competutor_site);
       $data["site_info2"] = DB::table("site_check_report")->where($where)->leftJoin("site_check_report_partial","site_check_report_partial.site_check_table_id","=","site_check_report.id")->get();
       if(!isset($data["site_info2"][0])) exit();

       $data["comparision_info"][0]->base_domain=$data["site_info"][0]->domain_name;
       $data["comparision_info"][0]->competutor_domain = $data["site_info2"][0]->domain_name;
       $page_title= strtolower($data["comparision_info"][0]->base_domain)." Vs ".strtolower($data["comparision_info"][0]->competutor_domain);

       $page_title=str_replace(array("www.","http://","https://"), "", $page_title);
       $data["page_title"]=$page_title;
    
       $data["load_css_js"]=1;
       $data["compare_report"]=1;
       $data["is_pdf"]=1;
       $data["recommendations"]=$this->recommendations();
       $data["spam_keywords"]=$this->spam_keywords();

       $desireLogoPath = storage_path('app/public/assets/logo');
       $desireFavPath = storage_path('app/public/assets/favicon');
       $data['logo'] = (file_exists($desireLogoPath) && !empty(File::files($desireLogoPath))) ? File::files($desireLogoPath)[0]->getFilename(): "";
       $data['favicon'] = (file_exists($desireFavPath) && !empty(File::files($desireFavPath))) ? File::files($desireFavPath)[0]->getFilename(): "";

       $data['direct_download'] = 1;
        if(config("settings.collect_visitor_email")=="1") 
            $data['direct_download'] = 0;

       // $pdf = PDF::loadView('domain.comparison_report', $data);
       // return $pdf->download('comparative_health_report.pdf');  


       $pdf = PDF::loadView('domain.comparison_report', $data, [], [
          'auto_language_detection' => true,
          'format' => 'Legal',
       ])->save(storage_path('app/public/comparative_download/'.$id.'.pdf'));

       $url = url(asset('storage/app/public/comparative_download/'.$id.'.pdf'));

       header("Content-type:application/pdf");
       // It will be called downloaded.pdf
       header("Content-Disposition:attachment;filename=".$id.".pdf");
       // The PDF source is in original.pdf
       readfile($url);
    }



    public function send_download_link_comparision(Request $request)
    {
        $name = trim($request->name);
        $email = trim($request->email);
        $id = trim($request->hidden_id);
        $lead_config = config("settings");

        if(is_array($lead_config)) {
          $allowed_download_per_email=$lead_config["report_download_limit"];
          $unlimited_download_emails=$lead_config["unlimited_report_access"];
        }
        else
        {
          $allowed_download_per_email=10;  
          $unlimited_download_emails="";
        }
        
        $unlimited_download_emails=explode(',',$unlimited_download_emails);
        $data=array("firstname"=>$name,"email"=>$email);


        $where = array('comparision.id'=>$id);
        $select=array("base_site_table.domain_name as base_domain","competutor_site_table.domain_name as competutor_domain","comparision.base_site","comparision.competutor_site","comparision.searched_at","comparision.id as id");

        $comparision_info = DB::table("comparision")
                            ->select($select)
                            ->leftJoin('site_check_report as base_site_table','comparision.base_site','=','base_site_table.id')
                            ->leftJoin('site_check_report as competutor_site_table','comparision.competutor_site','=','competutor_site_table.id')
                            ->where($where)
                            ->get();

        $domain="";
        if(isset($comparision_info[0]))
        {
          $domain= strtolower($comparision_info[0]->base_domain).", ".strtolower($comparision_info[0]->competutor_domain);
          $domain=str_replace(array("www.","http://","https://"), "", $domain);
        }             
        
        $ret_val="1";

        if(DB::table("leads")->select("id")->where("email",$email)->where("no_of_search",">=",$allowed_download_per_email)->exists())
        {
          if(!in_array($email,$unlimited_download_emails))
          {
            $ret_val= "0"; // crossed limit
            $response['error'] = true;
            $response['message'] = __("you can not download more result using this email, download quota is crossed");
            return response()->json($response);
          }
        }
        
        if($ret_val=="1")
        {               
            if(DB::table("leads")->select("id")->where("email",$email)->exists())
            {

                $sql = "UPDATE leads SET name='".$name."',no_of_search=no_of_search+1,domain=trim(both ',' from concat(domain, ', ".$domain."')),date_time='".date("Y-m-d H:i:s")."' WHERE email='".$email."'";
                DB::update($sql);
                $ret_val= "2"; // updated               
            }
            else 
            {
                DB::table("leads")->insert(array("name"=>$name,"domain"=>$domain,"email"=>$email,"no_of_search"=>1,"date_time"=>date("Y-m-d H:i:s")));
                syncMailchimp($data);
                $ret_val= "3"; // inserted
            }

            $sql2 = "UPDATE comparision SET email=trim(both ',' from concat(email, ', ".$email."')) WHERE id=".$id;
            DB::update($sql2);

            $product = config('settings.product_name');
            $subject = $product." | "."Health Check Report : ".$domain;

            $download_link="<a href='".route('domain.download.comparative.report',$id)."'> health check report of ".$domain."</a>";
            $message="Hello {$name}, <br/> Thank you for using {$product}.<br/> Please follow the link to download report: {$download_link}<br/><br/><br/>{$product} Team";

            $this->send_email($email,$message,$subject);
            $response['error'] = false;
            $response['message'] = __('An email with download link has sent to your email address. Please check.');
            return response()->json($response);
        }          
        
    }

    protected function spam_keywords()
    {
        return array("as seen on","buying judgments", "order status", "dig up dirt on friends","additional income", "double your", "earn per week", "home based", "income from home", "money making","opportunity", "while you sleep", "$$$", "beneficiary", "cash", "cents on the dollar", "claims","cost", "discount", "f r e e", "hidden assets", "incredible deal", "loans", "money","mortgage rates", "one hundred percent free", "price", "quote", "save big money", "subject to credit","unsecured debt", "accept credit cards", "credit card offers", "investment decision","no investment", "stock alert", "avoid bankruptcy", "consolidate debt and credit","eliminate debt", "get paid", "lower your mortgage rate", "refinance home", "acceptance","chance", "here", "leave", "maintained", "never", "remove", "satisfaction", "success", "dear [email/friend/somebody]", "ad", "click", "click to remove", "email harvest", "increase sales","internet market", "marketing solutions", "month trial offer", "notspam","open", "removal instructions", "search engine listings", "the following form", "undisclosed recipient","we hate spam", "cures baldness", "human growth hormone", "lose weight spam", "online pharmacy", "stop snoring", "vicodin", "#1", "4u", "billion dollars", "million", "being a member","cannot be combined with any other offer", "financial freedom", "guarantee","important information regarding", "mail in order form", "nigerian", "no claim forms", "no gimmick", "no obligation", "no selling", "not intended", "offer", "priority mail", "produced and sent out","stuff on sale", "theyâ€™re just giving it away", "unsolicited", "warranty", "what are you waiting for?","winner", "you are a winner!", "cancel at any time", "get", "print out and fax", "free", "free consultation", "free grant money", "free instant", "free membership", "free previewÂ ", "free sampleÂ ", "all natural", "certified", "fantastic deal", "itâ€™s effective",  "real thing","access", "apply online", "can't live without", "don't hesitate", "for you", "great offer", "instant", "now", "once in lifetime", "order now", "special promotion", "time limited", "addresses on cd","brand new pager", "celebrity", "legal", "phone", "buy", "clearance", "orders shipped by", "meet singles", "be your own boss", "earn $", "expect to earn", "home employment", "make $","online biz opportunity", "potential earnings", "work at home", "affordable","best price", "cash bonus", "cheap", "collect", "credit", "earn", "fast cash","hidden charges", "insurance", "lowest price", "money back", "no cost", "only '$'", "profits", "refinance",  "save up to",  "they keep your money -- no refund!",  "us dollars","cards accepted", "explode your business", "no credit check", "requires initial investment","stock disclaimer statementÂ ", "calling creditors", "consolidate your debt", "financially independent","lower interest rate", "lowest insurance rates", "social security number", "accordingly", "dormant","hidden", "lifetime", "medium", "passwords", "reverses", "solution", "teen", "friend","auto email removal", "click below", "direct email", "email marketing","increase traffic", "internet marketing", "mass email", "more internet traffic", "one time mailing","opt in", "sale", "search engines", "this isn't junk", "unsubscribe","web traffic", "diagnostics", "life insurance", "medicine", "removes wrinkles","valium", "weight loss", "100% free", "50% off", "join millions","one hundred percent guaranteed", "billing address", "confidentially on all orders", "gift certificate","have you been turned down?", "in accordance with laws", "message contains", "no age restrictions", "no disappointment", "no inventory", "no purchase necessary", "no strings attached", "obligation","per day", "prize", "reserves the right", "terms and conditions", "trial", "vacation","we honor all", "who really wins?", "winning", "you have been selected","compare", "give it away", "see for yourself", "free access", "free dvd", "free hosting","free investment", "free money", "free priority mail", "free trial","all new", "congratulations", "for free", "outstanding values", "risk free","act now!", "call free", "do it today", "for instant access", "get it now","info you requested", "limited time", "now only", "one time", "order today","supplies are limited", "urgent", "beverage", "cable converter", "copy dvds", "luxury car","rolex", "buy direct", "order", "shopper", "score with babes", "compete for your business","earn extra cash", "extra income", "homebased business", "make money", "online degree", "university diplomas", "work from home", "bargain", "big bucks", "cashcashcash",  "check","compare rates", "credit bureaus", "easy terms", 'for just "$xxx"',  "income",  "investment","million dollars", "mortgage", "no fees", "pennies a day", "pure profit",  "save $","serious cash", "unsecured credit", "why pay more?", "check or money order", "full refund","no hidden costs", "sent in compliance", "stock pick", "collect child support","eliminate bad credit", "get out of debt", "lower monthly payment", "pre-approved","your income", "avoid", "freedom", "home",  "lose", "miracle", "problem", "sample","stop", "wife", "hello", "bulk email", "click here", "direct marketing", "form","increase your sales", "marketing", "member", "multi level marketing", "online marketing", "performance", "sales", "subscribe", "this isn't spam", "visit our website", "will not believe your eyes", "fast viagra delivery", "lose weight","no medical exams", "reverses aging", "viagra", "xanax", "100% satisfied",  "billion", "join millions of americans",  "thousands", "call", "deal", "giving away","if only it were that easy", "long distance phone offer", "name brand", "no catch","no experience", "no middleman", "no questions asked",  "no-obligation", "off shore", "per week", "prizes", "shopping spree", "the best rates", "unlimited", "vacation offers",  "weekend getaway","win", "won", "youâ€™re a winner!", "copy accurately", "print form signature","sign up free today", "free cell phone", "free gift", "free installation","free leads", "free offer", "free quote", "free website",  "amazing",  "drastically reduced","guaranteed", "promise you", "satisfaction guaranteed", "apply now","call now", "don't delete", "for only", "get started now",  "information you requested","new customers only", "offer expires", "only", "please read","take action now", "while supplies last", "bonus", "casino","laser printer", "new domain extensions", "stainless steel");
    }
}