<?php

namespace App\Http\Controllers;

use App\Mail\SimpleHtmlEmail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Config;

class Home extends BaseController
{
    /**
    * load constructor
    * @access public
    * @return void
    */

    public $user_id = '';
    public $user_type = '';
    public $is_admin = false;
    public $is_member = false;
    public $expired_date = null;

    public $is_ad_enabled=false;
    public $is_ad_enabled1=false;
    public $is_ad_enabled2=false;
    public $is_ad_enabled3=false;
    public $is_ad_enabled4=false; 

    public $ad_content1="";
    public $ad_content1_mobile="";
    public $ad_content2="";
    public $ad_content3="";
    public $ad_content4="";
    public $app_product_id="";
    public $is_demo="";

    public function set_global_userdata()
    {
        set_time_limit(0);
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if(Auth::user()) {
                if(Auth::user()->status=='0') {
                    header('Location:'.route('logout'));
                    die;
                }
                
                $user_id = Auth::user()->id;
                session(['user_id' => $this->user_id]);
                $this->user_id = $user_id;

                $user_type = Auth::user()->user_type;

                if($user_type=='Admin') {
                    $this->is_admin = true;
                }
                else {
                    
                    $this->is_member = true;
                } 
                $this->app_product_id = 16950987;
                $this->user_type = $user_type;
                $this->expired_date = Auth::user()->expired_date;
                $is_demo = config("settings.is_demo");
                return $next($request);
            }
        });
    }

    protected function viewcontroller($data=array())
    {
        if (!isset($data['body'])) return false;
        if (!isset($data['iframe'])) $data['iframe'] = false;
        if (!isset($data['load_datatable'])) $data['load_datatable'] = false;
        $data['user_id'] = $this->user_id;
        $data['expired_date'] = $this->expired_date;
        $data['is_admin'] = $this->is_admin;
        $data['is_member'] = $this->is_member;

        $data['route_name'] = Route::currentRouteName();
        $data['get_selected_sidebar'] = get_selected_sidebar($data['route_name']);
        $data['full_width_page_routes'] = full_width_page_routes();

        $desireLogoPath = storage_path('app/public/assets/logo');
        $desireFavPath = storage_path('app/public/assets/favicon');
        $data['logo'] = 'logo.png';
        $data['favicon'] = 'favicon.png';
        
        return view($data['body'], $data);
    }


    protected function get_available_language_list(){
        if($this->is_admin) $user_id = 1;
        else if($this->is_agent) $user_id = $this->user_id;
        else $user_id = Auth::user()->parent_user_id;

        $all_language_list = get_language_list();

        $languages = ['en'=>'English'.' ('.__('System').')'];
        $files = File::allFiles(resource_path().DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'translation');

        foreach ($files as $key=>$value){
            $getRelativePath = $value->getRelativePath();
            if(!isset($languages[$getRelativePath])){
                $langName = rtrim($getRelativePath,'-'.$this->user_id);
                if(($this->is_admin || $this->parent_user_id==1)){
                    $languages[$getRelativePath] = $all_language_list[$langName] ?? $langName;
                }
            }
        }
        return $languages;
    }

    public function siteviewcontroller($data=array())
    {
        if (!isset($data['page_title']))  $data['page_title']="";        
        if (!isset($data['body']))        $data['body']="site/index";
        if (!isset($data['load_css_js'])) $data['load_css_js']=0;

        if (!isset($data['base_site'])  || $data['base_site']=="") {
            $data['base_site']=0;
            $data['compare']=0;
        }
        else $data['compare']=1;     

        if(!isset($data['seo_meta_description'])) {
            $data['seo_meta_description']= __('Check the health of your site. You will receive a report at the end of test and be able to download the pdf. You will provide suggestions corresponding each issue. Try now, how it works ! This is particularly needed for site admin');
        }
        if(!isset($data['seo_meta_keyword'])) {
            $data['seo_meta_keyword']=__('web analysis,web analyzer,seo analysis, seo analysis tool, website health checker, seo suggestion');   
        }

        //catcha for contact page
        $data['contact_num1']=$this->_random_number_generator(2);
        $data['contact_num2']=$this->_random_number_generator(2);
        $contact_captcha= $data['contact_num1']+ $data['contact_num2'];
        session(["contact_captcha"=>$contact_captcha]);

        //catcha for contact page
        if(session('download_id_front')=="") {
            session(['download_id_front'=>md5(time().$this->_random_number_generator(10))]);
        }

        if($data['body']=="landing.index") {
            // DB::enableQueryLog();
            $data['recent_search'] = DB::table("site_check_report")
                                        ->select(["site_check_report.id","domain_name","searched_at","total_words","external_link_count","internal_link_count","overall_score",'desktop_lighthouseresult_audits','mobile_lighthouseresult_audits'])
                                        ->leftJoin("site_check_report_partial","site_check_report_partial.site_check_table_id","=","site_check_report.id")
                                        ->offset(0)
                                        ->limit(10)
                                        ->orderBy('site_check_report.id','DESC')
                                        ->get();
                                        // dd(DB::getQueryLog());
                                        // echo "<pre>"; print_r($data['recent_search']); exit;
            $select=array("base_site_table.domain_name as base_domain","competutor_site_table.domain_name as competutor_domain","comparision.base_site","comparision.competutor_site","comparision.searched_at","comparision.id as id");
            $data["recent_comparison"] = DB::table("comparision")
                                            ->select($select)
                                            ->leftJoin("site_check_report as base_site_table","comparision.base_site","=","base_site_table.id")
                                            ->leftJoin("site_check_report as competutor_site_table","comparision.competutor_site","=","competutor_site_table.id")
                                            ->offset(0)
                                            ->limit(15)
                                            ->orderBy("comparision.id","DESC")
                                            ->get();
        }

        $desireLogoPath = storage_path('app/public/assets/logo');
        $desireFavPath = storage_path('app/public/assets/favicon');
        $data['logo'] = (file_exists($desireLogoPath) && !empty(File::files($desireLogoPath))) ? File::files($desireLogoPath)[0]->getFilename(): "";
        $data['favicon'] = (file_exists($desireFavPath) && !empty(File::files($desireFavPath))) ? File::files($desireFavPath)[0]->getFilename(): "";
        
        return view($data['body'],$data);
    }



    public function index()
    {
        $data['body'] = 'landing.index';
        $data['features_list'] = $this->get_features_content();

        if(file_exists(public_path("install.txt")))
            $data['body'] = 'landing.index_install';
        
        return $this->siteviewcontroller($data);
    }

    public function installation_submit(Request $request)
    {
        $rules = [];
        $rules['host_name'] = 'required';
        $rules['database_name'] = 'required';
        $rules['database_username'] = 'required';
        // $rules['database_password'] = 'required';
        $rules['app_username'] = 'required|email';
        $rules['app_password'] = 'required';
        $request->validate($rules);

        $host_name = $request->host_name;
        $database_name = $request->database_name;

        $database_username = $request->database_username;
        $database_password = $request->database_password;

        $app_username = $request->app_username;
        $app_password = $request->app_password;
        $institute_name = $request->institute_name;
        $institute_address = $request->institute_address;
        $institute_mobile = $request->institute_mobile;


        $con=@mysqli_connect($host_name, $database_username, $database_password);
        if (!$con) {
            $mysql_error = "Could not connect to MySQL : ";
            $mysql_error .= mysqli_connect_error();
            // $this->session->set_userdata('mysql_error', $mysql_error);
            // return $this->installation();
            echo $mysql_error;
        }
        if (!@mysqli_select_db($con,$database_name)) {
            // $this->session->set_userdata('mysql_error', "Database not found.");
            // return $this->installation();
            echo "database not found";
        }


        // $connection = mysqli_close($con);
        Config::set('database.connections.mysql.host', $host_name);   
        Config::set('database.connections.mysql.database',  $database_name);
        Config::set('database.connections.mysql.username', $database_username);
        Config::set('database.connections.mysql.password', $database_password);

        // dd(config('database.connections.mysql'));

        $path = base_path('.env');
        $initial_env = public_path('initial_env.txt');
        $test = file_get_contents($initial_env);
        if (file_exists($path))
        {
            $test = str_replace('DB_HOST=', 'DB_HOST='.$host_name, $test);
            $test = str_replace('DB_DATABASE=', 'DB_DATABASE='.$database_name, $test);
            $test = str_replace('DB_USERNAME=', 'DB_USERNAME='.$database_username, $test);
            $test = str_replace('DB_PASSWORD=', 'DB_PASSWORD='.$database_password, $test);
            file_put_contents($path,$test);
        }

        $dump_sql_path = public_path('initial_db.sql');
        $dump_file = $this->import_dump($dump_sql_path,$con);
        DB::table('version')->insert(['version'=>trim(env('APP_VERSION')),'current'=>'1','date'=>date('Y-m-d H:i:s')]);
        //generating hash password for admin and updaing database
        $app_password = Hash::make($app_password);
        DB::table('users')->where('user_type','Admin')->update(["mobile" => $institute_mobile, "email" => $app_username, "password" => $app_password, "name" => $institute_name, "status" => "1", "deleted" => "0", "address" => $institute_address]);
        //generating hash password for admin and updaing database

        //deleting the install.txt file,because installation is complete
        if (file_exists(public_path('install.txt'))) {
          unlink(public_path('install.txt'));
        }
        //deleting the install.txt file,because installation is complete
        return redirect('login');
    }

    public function import_dump($filename = '',$con='')
    {
        if ($filename=='') {
            return false;
        }
        if (!file_exists($filename)) {
            return false;
        }
        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file($filename);
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                // $this->execute_complex_query($templine);
                // DB::statement($templine);
                mysqli_query($con, $templine);
                // Reset temp variable to empty
                $templine = '';
            }
        }
        return true;

    }
    

    protected function send_email($email='', $email_reply_message='', $email_reply_subject='', $email_reply_message_header='')
    {
        set_email_config();
        
        if(empty($email) || empty($email_reply_message) || empty($email_reply_subject) ) return ['error'=>true,'message'=>__('Missing params.')];
        try
        {
            Mail::to($email)->send(new SimpleHtmlEmail($email_reply_message_header,$email_reply_message,$email_reply_subject));
            return ['error'=>false,'message'=>__('Email sent successfully.')];
        }
        catch(\Swift_TransportException $e){
            return ['error'=>true,'message'=>$e->getMessage()];
        }
        catch(\GuzzleHttp\Exception\RequestException $e){
            return ['error'=>true,'message'=>$e->getMessage()];
        }
        catch(Exception $e) {
            return ['error'=>true,'message'=>$e->getMessage()];
        }

    }

    protected function get_features_content()
    {
        return [
            [
                'icon' =>'lni lni-display',
                'title' =>'SaaS Focused',
                'body' =>'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore'
            ],
            [
                'icon' =>'lni lni-leaf',
                'title' =>'Awesome Design',
                'body' =>'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                  diam nonumy eirmod tempor invidunt ut labore'
            ],
            [
                'icon' =>'lni lni-grid-alt',
                'title' =>'Ready to Use',
                'body' =>'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                  diam nonumy eirmod tempor invidunt ut labore'
            ],
            [
                'icon' =>'lni lni-javascript',
                'title' =>'Vanilla JS',
                'body' =>'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                  diam nonumy eirmod tempor invidunt ut labore'
            ],
            [
                'icon' =>'lni lni-layers',
                'title' =>'Essential Sections',
                'body' =>'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                  diam nonumy eirmod tempor invidunt ut labore'
            ],
            [
                'icon' =>'lni lni-rocket',
                'title' =>'Highly Optimized',
                'body' =>'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                  diam nonumy eirmod tempor invidunt ut labore'
            ],

        ];
    }

    protected function recommendations()
    {
        $config['page_title_recommendation'] = 'Title is the heading of the webpage. The sentence or string enclosed between html title tag (<title></title>) is the title of your website. Search engines searches for the title of your website and displays title along with your website address on search result. Title is the most important element for both SEO and social sharing. Title should be less than 50 to 60 characters because search engine typically displays this length of string or sentence on search result. A good title can consist the primary keyword, secondary keyword and brand name. For example a fictitious gaming information providing sites title may be like "the future of gaming information is here".  A webpage title should contain a proper glimpse of the website. title is important element as an identification of your website for user experience, SEO and social sharing. So have a nice and catching title. <br/> <a href="https://moz.com/learn/seo/title-tag" target="_BLANK"> <i class="fa fa-hand-o-right"></i> Learn more</a>';
        $config['description_recommendation']="Description is the full interpretation of your website content and features. Most often it is a short paragraph that describe what are features and information provided by the website to its visitors. You may consider it a advertising of your website. Although not important for search engine ranking but very important for hits or visits through search engine results. Description should be less than 150 character because search engine shows this length of paragraph on search result. And every page of website should contain an unique description to avoid description duplication. Description is the definition of your website for user experience so form it as complete but short and precise illustration of your website.";
        $config['meta_keyword_recommendation']="Meta keywords are keywords inside Meta tags. Meta keywords are not likely to be used for search engine ranking. the words of title and description can be used as meta keywords. it is a good idea for SEO other than search engine ranking.";
        $config['keyword_usage_recommendation']="Keyword usage is the using of your keywords inside Meta tags and contents of your website. Use keywords that describes your site properly for precise search engine result of your website.";
        $config['unique_stop_words_recommendation']="Unique words are uncommon words that reflects your site features and informations. Search engine metrics are not intended to use unique words as ranking factor but it is still useful to get a proper picture of your site contents. Using positive unique words like complete, perfect, shiny, is a good idea user experience.<br/><br/>
        Stop words are common words like all the preposition, some generic words like download, click me, offer, win etc. since most used keyword may be a slight factor for visitors you are encouraged to use more unique words and less stop words.";
        $config['heading_recommendation']="h1 status is the existence of any content inside h1 tag. Although not important like Meta titles and descriptions for search engine ranking but still a good way to describe your contents in search engine result.<br/><br/>
        h2 status less important but should be used for proper understanding of your website for visitor.";
        $config['robot_recommendation']='robots.txt is text file that reside on website root directory and contains the instruction for various robots (mainly search engine robots) for how to crawl and indexing your website for their webpage. robots.txt contains the search bots or others bots name, directory list allowed or disallowed to be indexing and crawling for bots, time delay for bots to crawl and indexing and even the sitemap url. A full access or a full restriction or customized access or restriction can be imposed through robots.txt.<br><br>
        robots.txt is very important for SEO. Your website directories will be crawled and indexed on search engine according to robots.txt instructions. So add a robots.txt file in your website root directory. Write it properly including your content enriched pages and other public pages and exclude any pages which contain sensitive information. Remember robots.txt instruction to restrict access to your sensitive information of your page is not formidable on web page security ground. So do not use it on security purpose.
        <br/> <a href="http://www.robotstxt.org/robotstxt.html" target="_BLANK"> <i class="fa fa-hand-o-right"></i> Learn more</a>';
        $config['sitemap_recommendation']='Sitemap is a xml file which contain full list of your website urls. It is used to include directories of your websites for crawling and indexing for search engine and access for users. it can help search engine robots for indexing your website more fast and deeply.  It is roughly an opposite of robots.txt
        You can create a sitemap.xml by various free and paid service or you can write it with proper way (read about how write a sitemap). <br><br>
        <b>Also keep these things in mind:</b> <br/>
        1) Sitemap must be less than 10 MB (10,485,760 bytes) and can contain maximum 50,000 urls. if you have more uls than this create multiple sitemap files and use a sitemap index file.<br/>
        2) Put your sitemap in website root directory and add the url of your sitemap in robots.txt.<br/>
        3) sitemap.xml can be compressed using grip for faster loading.<br/><br/>
        <b>Broken link:</b> a broken link is an inaccessible link or url of a website. a higher rate of broken links have a negative effect on search engine ranking due to reduced link equity. it also has a bad impact on user experience. There are several reasons for broken link. All are listed below.<br/>
        1) An incorrect link entered by you. <br/>
        2) The destination website removed the linked web page given by you. (A common 404 error).<br/>
        3) The destination website is irreversibly moved or not exists anymore. (Changing domain or site blocked or dysfunctional).<br/>
        4) User may behind some firewall or alike software or security mechanism that is blocking the access to the destination website.<br/>
        5) You have provided a link to a site that is blocked by firewall or alike software for outside access.<br/>
        <a href="http://www.sitemaps.org/protocol.html" target="_BLANK"> <i class="fa fa-hand-o-right"></i> Learn more</a> or <a href="http://webdesign.tutsplus.com/articles/all-you-need-to-know-about-xml-sitemaps--webdesign-9838" target="_BLANK"> <i class="fa fa-hand-o-right"></i> Learn more</a>';
        $config['no_do_follow_recommendation']='<p>
          <strong>NoIndex : </strong>noindex directive is a meta tag value. noindex directive  is for not to show your website on search engine results. You must not set &lsquo;noindex&rsquo; as value in meta tags if you want to be your website on search engine result.</p>
        <p>
          By default, a webpage is set to &ldquo;index.&rdquo; You should add a <code>&lt;meta name=&quot;robots&quot; content=&quot;noindex&quot; /&gt;</code> directive to a webpage in the &lt;head&gt; section of the HTML if you do not want search engines to crawl a given page and include it in the SERPs (Search Engine Results Pages).</p>
        <p>
          <strong>DoFollow &amp; NoFollow : </strong>nofollow directive is a meta tag value. Nofollow directive  is for not to follow any links of your website by search engine bots. You must not set &lsquo;nofollow&rsquo; as value in meta tags if you want follow your link by search engine bots.</p>
        <p>
          By default, links are set to &ldquo;follow.&rdquo; You would set a link to &ldquo;nofollow&rdquo; in this way: <code>&lt;a href=&quot;http://www.example.com/&quot; rel=&quot;nofollow&quot;&gt;Anchor Text&lt;/a&gt;</code> if you want to suggest to Google that the hyperlink should not pass any link equity/SEO value to the link target.</p>
        <p>
          <a target="_BLANK" href="http://www.launchdigitalmarketing.com/seo-tips/difference-between-noindex-and-nofollow-meta-tags/"><i class="fa fa-hand-o-right"></i> Learn more</a></p>';
        $config['seo_friendly_recommendation']='An SEO friendly link is roughly follows these rules. The url should contain dash as a separator, not to contain parameters and numbers and should be static urls.<br><br>
        To resolve this use these techniques.<br>
        1) Replace underscore or other separator by dash, clean url by deleting or replaceing number and parameters. <br>
        2) Marge your www and non www urls.<br>
        3) Do not use dynamic and related urls. Create an xml sitemap for proper indexing of search engine.<br>
        4) Block unfriendly and irrelevant links through robots.txt.<br>
        5) Endorse your canonical urls in canonical tag.<br/>
        <a target="_BLANK" href="https://www.searchenginejournal.com/five-steps-to-seo-friendly-site-url-structure/"><i class="fa fa-hand-o-right"></i> Learn more</a>';
        $config['img_alt_recommendation']='An alternate title for image. Alt attribute content to describe an image. It is necessary for notifying search engine spider and improve actability to your website. So put a suitable title for your image at least those are your website content not including the images for designing your website. To resolve this put a suitable title in your alt attributes.<br>
        <a target="_BLANK" href="https://yoast.com/image-seo-alt-tag-and-title-tag-optimization/"><i class="fa fa-hand-o-right"></i>  Learn more</a>';
        $config['depreciated_html_recommendation']="Older HTML tags and attributes that have been superseded by other more functional or flexible alternatives (whether as HTML or as CSS ) are declared as deprecated in HTML4 by the W3C - the consortium that sets the HTML standards. Browsers should continue to support deprecated tags and attributes, but eventually these tags are likely to become obsolete and so future support cannot be guaranteed.";
        $config['inline_css_recommendation']="Inline css is the css code reside in html page under html tags not in external .css file. Inline css increases the loading time of your webpage which is an important search engine ranking factor. So try not to use inline css.";
        $config['internal_css_recommendation']="Internal css is the css codes which resides on html page inside style tag. Internal css is increases loading time since no page caching is possible for internal css. Try to put your css code in external file.";
        $config['html_page_size_recommendation']='HTML page size is the one of the main factors of webpage loading time. It should be less than 100 KB according to google recommendation. Note that, this size not including external css, js or images files. So small page size less loading time.<br><br>
        To reduce your page size do this steps<br>
        1) Move all your css and js code to external file.<br>
        2) make sure your text content be on top of the page so that it can displayed before full page loading.<br>
        3) Reduce or compress all the image, flash media file etc. will be better if these files are less than 100 KB<br>
        <a target="_BLANK" href="https://www.searchenginejournal.com/seo-recommended-page-size/10273/"><i class="fa fa-hand-o-right"></i>  Learn more</a>';
        $config['gzip_recommendation']="GZIP is a generic compressor that can be applied to any stream of bytes: under the hood it remembers some of the previously seen content and attempts to find and replace duplicate data fragments in an efficient way - for the curious, great low-level explanation of GZIP. However, in practice, GZIP performs best on text-based content, often achieving compression rates of as high as 70-90% for larger files, whereas running GZIP on assets that are already compressed via alternative algorithms (e.g. most image formats) yields little to no improvement. It is also recommended that, GZIP compressed size should be <=33 KB";
        $config['doc_type_recommendation']='doc type is not SEO factor but it is checked for validating your web page. So set a doctype at your html page.<br> <a target="_BLANK" href="http://www.pitstopmedia.com/sem/doctype-tag-seo"><i class="fa fa-hand-o-right"></i> Learn more</a>';
        $config['micro_data_recommendation']='Micro data  is the information underlying a html string or paragraph. Consider a string “Avatar”, it could refer a profile picture on forum, blog or social networking site or may it refer to a highly successful 3D movie. Microdot is used to specify the reference or underlying information about an html string. Microdata gives chances to search engine and other application for better understanding of your content and better display significantly on search result.
        <br> <a target="_BLANK" href="https://schema.org/docs/gs.html"><i class="fa fa-hand-o-right"></i> Learn more</a>';
        $config['ip_canonicalization_recommendation']='If multiple domain name is registered under single ip address the search bots can label other sites as duplicates of one sites. This is ip canonicalization. Little bit like url canonicalizaion. To solve this use redirects.
        <br> <a target="_BLANK" href="http://www.phriskweb.com.au/DIY-SEO/ip-canonicalization"><i class="fa fa-hand-o-right"></i> Learn more</a>';
        $config['url_canonicalization_recommendation']='Canonical tags make your all urls those lead to a single address or webpage into a single url. Like : <br>
        <code>&lt;link rel="canonical" href="https://mywebsite.com/home" /&gt;</code><br>
        <code>&lt;link rel="canonical" href="https://www.mywebsite.com/home" /&gt;</code><br>
        Both refer to the link mywebsite.com/home. So all the different url with same content or page now comes under the link or url mywebsite.com/home. Which will boost up your search engine ranking by eliminating content duplication.
        Use canonical tag for all the same urls.<br> <a target="_BLANK" href="https://audisto.com/insights/guides/28/"><i class="fa fa-hand-o-right"></i> Learn more</a>';
        $config['plain_email_recommendation']='Plain text email address is vulnerable to email scrapping agents. An email scrapping agent crawls your website and collects every Email address which written in plain text. So existence of plain text email address in your website can help spammers in email Harvesting. This could be a bad sign for search engine.<br/><br/>
        <b>To fight this you can obfuscate your email addresses in several ways:</b> <br/>
        1) CSS pseudo classes.<br/>
        2) Writing backward your email address.<br/>
        3) Turn of display using css.<br/>
        4) Obfuscate your email address using javascript.<br/>
        5) Using wordpress and php (wordpress site only).<br/>
        <a target="_BLANK" href="http://www.labnol.org/internet/hide-email-address-web-pages/28364/"><i class="fa fa-hand-o-right"></i> Learn more</a>';
        $config['text_to_html_ratio_recommendation']="The ideal page's ratio of text to HTML code must be lie between 20 to 60%.
        Because if it is come less than 20% it means you need to write more text in your web page while in case of more than 60% your page might be considered as spam.";
        
        return $config;
    }

    public function _random_number_generator($length=6)
    {
        $rand = substr(uniqid(mt_rand(), true), 0, $length);
        return $rand;
    }
    public function privacy_policy()
    {
        return view('landing.gdpr.privacy_policy');
    }
    public function toc()
    {
        return view('landing.gdpr.toc');
    }
    public function refund_policy()
    {
        return view('landing.gdpr.refund_policy');
    }

    protected function delete_directoryX($dirPath="") 
    {
        if (!is_dir($dirPath)) 
        return false;

        if(substr($dirPath, strlen($dirPath) - 1, 1) != '/') $dirPath .= '/';
        
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach($files as $file) 
        {
            if(is_dir($file)) $this->delete_directory($file);             
            else @unlink($file);            
        }
        rmdir($dirPath);
    }



    public function important_feature($redirect=true)
    {
        if(File::exists(base_path('config/licence.txt')) && File::exists(base_path('assets/licence.txt')))
        {
            $config_existing_content = File::get(base_path('config/licence.txt'));
            $config_decoded_content = json_decode($config_existing_content, true);

            $core_existing_content = File::get(base_path('assets/licence.txt'));
            $core_decoded_content = json_decode($core_existing_content, true);

            if($config_decoded_content['is_active'] != md5($config_decoded_content['purchase_code']) || $core_decoded_content['is_active'] != md5(md5($core_decoded_content['purchase_code'])))
            {
                if($redirect)
                    return redirect()->route('credential-check');
                else
                    return false;
            }
        } 
        else 
        {
            if($redirect)
                return redirect()->route('credential-check');
            else
                return false;
        }

        return true;
    }


    public function credential_check()
    {
        $permission = 0;
        if(Auth::user()->user_type =="Admin") $permission = 1;
        else $permission = 0;
        if($permission == 0) abort(403);

        $data["page_title"] = __("Credential Check");
        $data['body'] = 'site.credential_check';
        return $this->viewcontroller($data);($data);
    }

    public function credential_check_action(Request $request)
    {
        $domain_name = $request->domain_name;
        $purchase_code = $request->purchase_code;
        $only_domain = get_domain_only($domain_name);
        $response=$this->code_activation_check_action($purchase_code,$only_domain);
        echo json_encode($response);
    }

    function get_general_content_with_checking($url,$proxy="")
    {
        $ch = curl_init(); // initialize curl handle
        /* curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);*/
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
        curl_setopt($ch, CURLOPT_REFERER, 'http://'.$url);
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 120); // times out after 50s
        curl_setopt($ch, CURLOPT_POST, 0); // set POST method


        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");
        // curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");

        $content = curl_exec($ch); // run the whole process
        $response['content'] = $content;

        $res = curl_getinfo($ch);
        if($res['http_code'] != 200)
            $response['error'] = 'error';
        curl_close($ch);
        return json_encode($response);

    }

    public function code_activation_check_action($purchase_code,$only_domain,$periodic=0)
    {

        $url = "https://xeroneit.net/development/envato_license_activation/purchase_code_check.php?purchase_code={$purchase_code}&domain={$only_domain}&item_name=SiteDoctor";
        $credentials = $this->get_general_content_with_checking($url);
        
        $decoded_credentials = json_decode($credentials,true);
        $decoded_credentials = json_decode($decoded_credentials['content'],true);
        // isset($decoded_credentials['status']) && $decoded_credentials['status'] == 'error'
        if(isset($decoded_credentials['error']))
        {
            $url = "https://mostofa.club/development/envato_license_activation/purchase_code_check.php?purchase_code={$purchase_code}&domain={$only_domain}&item_name=SiteDoctor";
            $credentials = $this->get_general_content_with_checking($url);
            $decoded_credentials = json_decode($credentials,true);
            
        }
        
        if(!isset($decoded_credentials['error']))
        {
            if($decoded_credentials['status'] == 'success')
            {
                $content_to_write = array(
                    'is_active' => md5($purchase_code),
                    'purchase_code' => $purchase_code,
                    'item_name' => $decoded_credentials['item_name'],
                    'buy_at' => $decoded_credentials['buy_at'],
                    'licence_type' => $decoded_credentials['license'],
                    'domain' => $only_domain,
                    'checking_date'=>date('Y-m-d')
                    );
                    
                $config_json_content_to_write = json_encode($content_to_write);
                file_put_contents(base_path('config/licence.txt'), $config_json_content_to_write, LOCK_EX);

                    
                $content_to_write['is_active'] = md5(md5($purchase_code));
                $core_json_content_to_write = json_encode($content_to_write);
                file_put_contents(base_path('assets/licence.txt'), $core_json_content_to_write, LOCK_EX);

                return json_encode($decoded_credentials);
            } 
            else if($decoded_credentials['status'] == 'error'){
                if(File::exists(base_path('config/licence.txt'))) unlink(base_path('config/licence.txt'));
                return json_encode($decoded_credentials);
            }
        }
        else
        {
            if($periodic == 1)
                return json_encode(['status'=>"success"]);
            else
            {
                $response['reason'] = __('cURL is not working properly, please contact your hosting provider.');
                return json_encode($response);
            }
        }
    }


  
}
