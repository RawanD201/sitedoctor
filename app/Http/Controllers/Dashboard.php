<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DB;

class Dashboard extends Home
{
    public function index()
    {
        $is_passed = $this->important_feature($redirect=false);
        if(!$is_passed) return redirect()->route('credential-check');
        
        $demo_mode = false;
        $last_seven_days_graph_data = $last_seven_days_data = $last_30_days_data = $last_30_days_graph_data = $total_email = $total_download = [];

        $total_site_checked = DB::table("site_check_report")->select(['site_check_report.id','domain_name','overall_score','searched_at'])->leftJoin("site_check_report_partial","site_check_report_partial.site_check_table_id","=","site_check_report.id")->orderBy(DB::raw("DATE_FORMAT(searched_at,'%Y-%m-%d')"),"DESC")->get();
        // echo "<pre>"; print_r($total_site_checked); exit;
        $top_five_domain_based_on_overall_score = $total_site_checked->toArray();
        $top_five_domain_based_on_overall_score = array_slice($top_five_domain_based_on_overall_score, 0, 5, true);

        $total_comparative_checked = DB::table("comparision")->count();
        $download_based_top_emails = DB::table("leads")->select(['name','email','no_of_search','date_time'])->orderBy(DB::raw("DATE_FORMAT(date_time,'%Y-%m-%d')"),"DESC")->get();

        $download_based_top_emails = $download_based_top_emails->toArray();
        $top_five_download_based_top_emails = array_slice($download_based_top_emails, 0, 5, true);

        $to_date = date("Y-m-d");
        $from_date = date("Y-m-d", strtotime($to_date.' - 6 days'));
        $last_30th_day = date("Y-m-d", strtotime($to_date.' - 30 days'));

        $get_last_seven_days_report_data = DB::table("site_check_report")
                                            ->where(DB::raw("DATE_FORMAT(searched_at,'%Y-%m-%d')"),">=",$from_date)
                                            ->where(DB::raw("DATE_FORMAT(searched_at,'%Y-%m-%d')"),"<=",$to_date)
                                            ->select(DB::raw('DATE_FORMAT(searched_at,"%Y-%m-%d") as checked_date'), DB::raw('count(*) as total_searched'))
                                            ->groupBy(DB::raw("DATE_FORMAT(searched_at,'%Y-%m-%d')"))
                                            ->get();    

        foreach($get_last_seven_days_report_data as $index => $value) {
            $last_seven_days_data[$value->checked_date] = $value->total_searched;
        }


        for($i=0; $i < 7 ; $i++) {

            $the_day = date("Y-m-d", strtotime('today - ' .$i .' days'));

            if(!array_key_exists($the_day, $last_seven_days_data)) {
                $last_seven_days_data[$the_day] = 0;
            }

            $last_seven_days_graph_data[date("j M", strtotime($the_day))] = $last_seven_days_data[$the_day];
        }

        $large_val = array();
        $max_values = 1;
        if(!empty($last_seven_days_data)) array_push($large_val, max($last_seven_days_graph_data));
        if(!empty($large_val)) $max_values = max($large_val);
        if($max_values > 100) $stepSize = floor($max_values/100);
        else $stepSize = 1;


        $get_30_days_collected_emails = DB::table("leads")
                                        ->where(DB::raw("DATE_FORMAT(date_time,'%Y-%m-%d')"),">=",$last_30th_day)
                                        ->where(DB::raw("DATE_FORMAT(date_time,'%Y-%m-%d')"),"<=",$to_date)
                                        ->select(DB::raw('DATE_FORMAT(date_time,"%Y-%m-%d") as added_at'), DB::raw('count(*) as total_email'), DB::raw('SUM(no_of_search) as total_searched'))
                                        ->groupBy(DB::raw("DATE_FORMAT(date_time,'%Y-%m-%d')"))
                                        ->get();
                                        // echo "<pre>"; print_r($get_30_days_collected_emails); exit;

        foreach($get_30_days_collected_emails as $key => $value) {
            $last_30_days_data[$value->added_at]['total_email'] = $value->total_email;
            $last_30_days_data[$value->added_at]['total_download'] = $value->total_searched;
        }


        for($i = 29; $i >= 0; $i--) {

            $theday = date("Y-m-d", strtotime('today - ' .$i .' days'));

            if(!array_key_exists($theday, $last_30_days_data)) {
                $last_30_days_data[$theday]['total_email'] = 0;
                $last_30_days_data[$theday]['total_download'] = 0;
            }

            // $last_30_days_graph_data[date("j M", strtotime($theday))] = $last_30_days_data[$theday];
            $last_30_days_graph_data[date("j M", strtotime($theday))] = $last_30_days_data[$theday];
        }

        foreach($last_30_days_graph_data as $key => $value) {
            $total_email[$key] = $value['total_email'];
            $total_download[$key] = $value['total_download'];
        }

        $large_val2 = array();
        $max_values2 = 1;
        if(!empty($last_30_days_data)) array_push($large_val, max($total_download));
        if(!empty($large_val2)) $max_values2 = max($large_val2);
        if($max_values2 > 100) $stepSize2 = floor($max_values2/100);
        else $stepSize2 = 1;

        if($demo_mode) {
            $last_seven_days_graph_data = $this->demo_data('seven_days_site');
            $total_download = $this->demo_data('download');
            $total_email = $this->demo_data('emails');
        }

        $data['stepSize'] = $stepSize;
        $data['stepSize2'] = $stepSize2;
        $data['last_seven_days_graph_data'] = $last_seven_days_graph_data;
        $data['last_30_days_graph_data'] = $last_30_days_graph_data;
        $data['total_email'] = $total_email;
        $data['total_download'] = $total_download;
        $data['total_site_checked'] = $total_site_checked;
        $data['total_comparative_checked'] = $total_comparative_checked;
        $data['total_email_collected'] = count($download_based_top_emails);
        $data['top_5_domain'] = (!$demo_mode) ? $top_five_domain_based_on_overall_score: $this->demo_list('domain');
        $data['top_5_emails'] = (!$demo_mode) ? $top_five_download_based_top_emails: $this->demo_list('email');
        $data['body']='dashboard';
        $data['load_datatable']= false;

        return $this->viewcontroller($data);
    }


    protected function demo_data($type='download')
    {
        $rand = 100;
        if($type=="emails") $rand = 100;
        if($type=="seven_days_site") $rand = 100;

        $data = array( 
            date('j M',strtotime('2021-11-15')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-16')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-17')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-18')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-19')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-20')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-21')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-22')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-23')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-24')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-25')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-26')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-27')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-28')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-29')) => rand(0,$rand), 
            date('j M',strtotime('2021-11-30')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-01')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-02')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-03')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-04')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-05')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-06')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-07')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-08')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-09')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-10')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-11')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-12')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-13')) => rand(0,$rand), 
            date('j M',strtotime('2021-12-14')) => rand(0,$rand),
        );
        // echo "<pre>"; print_r($data); exit;

        if($type=='seven_days_site') $data = array_slice($data, 0,7,true);
        return $data;

    }


    protected function demo_list($type='email')
    {         
        $emailList = [
            0 => (object) [
                'name' => 'Kaitlin Kulas',
                'email' => 'geraldine.fisher@gmail.com',
                'no_of_search' => '30',
            ],
            1 => (object) [
                'name' => 'Kelly Rempel',
                'email' => 'jena18@blick.com',
                'no_of_search' => '10',
            ],
            2 => (object) [
                'name' => 'Mozell Cole',
                'email' => 'zjohns@morissette.com',
                'no_of_search' => '15',
            ],
            3 => (object) [
                'name' => 'Vesta Hahn',
                'email' => 'frances19@yahoo.com',
                'no_of_search' => '5',
            ],
            4 => (object) [
                'name' => 'Devon Schuppe PhD',
                'email' => 'duncan19@hauck.com',
                'no_of_search' => '11',
            ],
        ];

        $domainList = [
            0 => (object) [
                'domain_name' => 'https://facebook.com',
                'overall_score' => '21.2',
            ],
            1 => (object) [
                'domain_name' => 'https://twitter.com',
                'overall_score' => '56.5',
            ],
            2 => (object) [
                'domain_name' => 'https://linkedin.com',
                'overall_score' => '72.1',
            ],
            3 => (object) [
                'domain_name' => 'https://medium.com',
                'overall_score' => '50.22',
            ],
            4 => (object) [
                'domain_name' => 'https://reddit.com',
                'overall_score' => '44',
            ],
        ];

        return ($type=="email") ? $emailList:$domainList;
    }
}