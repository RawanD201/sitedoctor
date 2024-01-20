<?php

namespace App\Http\Controllers;

// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Form;
// use File;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;



class Settings extends Home
{
    public function __construct()
    {
        $this->set_global_userdata();
    }

    public function index()
    {
        $data['body'] = 'admin.settings';
        $data['load_datatable'] = true;
        $data['language_list'] = $this->get_available_language_list();
        $general_settings = $lead_settings = $advertisement_settings = [];

        return $this->viewcontroller($data);
    }

    public function settings_action(Request $request)
    {        
        if(config('settings.is_demo') == '1') abort(403);

        $rules = [];
        $rules['logo'] = 'nullable|sometimes|image|mimes:png,jpg,jpeg,webp|max:1024';
        $rules['favicon'] = 'nullable|sometimes|image|mimes:png,jpg,jpeg,webp|max:100';
        $rules['google_api_key'] = 'nullable|sometimes';

        $validate_data = $request->validate($rules);

        if ($request->file('logo')) {

            $file = $request->file('logo');
            $extension = $request->file('logo')->getClientOriginalExtension();
            $filename =  'logo.png';
            $prev_logo = storage_path("app/public/assets/logo");
            File::cleanDirectory($prev_logo);
            $request->file('logo')->storeAs(
                'public/assets/logo',
                $filename
            );
        }

        if ($request->file('favicon')) {

            $file = $request->file('favicon');
            $extension = $request->file('favicon')->getClientOriginalExtension();
            $filename = 'favicon.png';

            $prev_favicon = storage_path("app/public/assets/favicon");
            File::cleanDirectory($prev_favicon);
            $request->file('favicon')->storeAs(
                'public/assets/favicon',
                $filename
            );
        }
        $config_data['company_name'] = $request->company_name;
        $config_data['company_address'] = $request->company_address;
        $config_data['company_email'] = $request->company_email;
        $config_data['company_mobile'] = $request->company_mobile;
        $config_data['language'] = $request->language;
        $config_data['timezone'] = $request->timezone;
        $config_data['product_name'] = $request->product_name;
        $config_data['product_version'] = $request->product_version;

        if ($request->has('google_api_key')) {
            $config_data['google_api_key'] = $request->google_api_key ?? '';
        }

        $config_data['collect_visitor_email'] = $request->collect_visitor_email ?? '0';
        $config_data['mailchimp_api_key'] = $request->mailchimp_api_key ?? '';
        $config_data['mailchimp_list_id'] = $request->mailchimp_list_id ?? '';
        $config_data['report_download_limit'] = $request->report_download_limit ?? '0';
        $config_data['unlimited_report_access'] = $request->unlimited_report_access ?? '';


        $config_data['advertisement_status'] = $request->advertisement_status ?? '0';
        $config_data['section_1_wide'] = $request->section_1_wide ?? '';
        $config_data['section_1_mobile'] = $request->section_1_mobile ?? '';
        // $config_data['section_2'] = $request->section_2 ?? '';
        // $config_data['section_3'] = $request->section_3 ?? '';
        $config_data['section_4'] = $request->section_4 ?? '';

        $config_data['social_media_facebook'] = $request->social_media_facebook ?? '';
        $config_data['social_media_facebook_status'] = $request->social_media_facebook_status ?? '0';
        $config_data['social_media_twitter'] = $request->social_media_twitter ?? '';
        $config_data['social_media_twitter_status'] = $request->social_media_twitter_status ?? '0';
        $config_data['social_media_instagram'] = $request->social_media_instagram ?? '';
        $config_data['social_media_instagram_status'] = $request->social_media_instagram_status ?? '0';
        $config_data['social_media_linkedin'] = $request->social_media_linkedin ?? '';
        $config_data['social_media_linkedin_status'] = $request->social_media_linkedin_status ?? '0';
        $config_data['is_demo'] = config('settings.is_demo');
            
        $text = '<?php ' . "\r\n \t" . 'return ' . var_export($config_data, true) . ';';
        file_put_contents(config_path('settings.php'), $text);

        @\Artisan::call('config:clear');
        
        $request->session()->flash('settings_saved', __('1'));
        return redirect(route('settings.index'));
    }

    public function get_email_lists(Request $request)
    {
        $search_value = !is_null($request->input('search.value')) ? $request->input('search.value') : '';
        $display_columns = array('#', 'id', 'email_address', 'smtp_host', 'smtp_port', 'smtp_user', 'status', 'actions');
        $search_columns = array('email_address', 'smtp_host', 'smtp_port');

        $page = isset($request->page) ? intval($request->page) : 1;
        $start = isset($request->start) ? intval($request->start) : 0;
        $limit = isset($request->length) ? intval($request->length) : 10;
        $sort_index = !is_null($request->input('order.column')) ? strval($request->input('order.column')) : 1;
        $sort = !is_null($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'id';
        $order = !is_null($request->input('order.0.dir')) ? strval($request->input('order.0.dir')) : 'desc';
        $order_by = $sort . " " . $order;

        $table = "email_config";
        $query = DB::table($table);
        if ($search_value != '') {
            $query->where(function ($query) use ($search_columns, $search_value) {
                foreach ($search_columns as $key => $value) $query->orWhere($value, 'like',  "%$search_value%");
            });
        }

        $info = $query->orderByRaw($order_by)->offset($start)->limit($limit)->get();

        $query = DB::table($table);
        if ($search_value != '') {
            $query->where(function ($query) use ($search_columns, $search_value) {
                foreach ($search_columns as $key => $value) $query->orWhere($value, 'like',  "%$search_value%");
            });
        }
        $total_result = $query->count();

        foreach ($info as $key => $value) {
            if(config('settings.is_demo') == '1')
            {
                $value->email_address = '***************';
                $value->smtp_host = '***************';
                $value->smtp_port = '***************';
                $value->smtp_user = '***************';
            }
            if ($value->status == '1') {
                $value->status = '<span class="badge bg-success">' . __('Active') . '</span>';
            } else {
                $value->status = '<span class="badge bg-danger">' . __('Inactive') . '</span>';
            }
            $value->actions = '<div><a href="" class="btn btn-circle btn-warning edit_email_config" table_id="' . $value->id . '"><i class="fas fa-edit"></i></a>&nbsp;<a href="" class="btn btn-circle btn-danger delete_email_config" table_id="' . $value->id . '"><i class="fas fa-trash-alt"></i></a></div>';
        }

        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = array_format_datatable_data($info, $display_columns, $start);
        echo json_encode($data);
    }

    public function save_email_settings(Request $request)
    {
        if(config('settings.is_demo') == '1') abort(403);

        $data = [];
        $data['email_address'] = $request->profile_name;
        $data['smtp_host'] = $request->host;
        $data['smtp_user'] = $request->username;
        $data['smtp_password'] = $request->password;
        $data['smtp_port'] = $request->port;
        $data['encryption'] = $request->encryption ?? 'Default';
        $data['status'] = $request->email_status ?? '0';

        $id = $request->email_table_id ?? '';


        DB::beginTransaction();
        try {

            if ($id != '') {
                DB::table("email_config")->where("id", $id)->update($data);
                if (DB::table('email_config')->where("id", "!=", $id)->count() > 0 && $request->email_status == '1') {
                    DB::table('email_config')->where('status', '1')->where('id', '!=', $id)->update(['status' => '0']);
                }

                $status = '1';
                $message = __('Email Settings has been updated successfully');
            } else {
                if (DB::table('email_config')->insert($data)) {
                    $insertId = DB::getPdo()->lastInsertId();

                    if (DB::table('email_config')->count() > 0 && $request->email_status == '1') {
                        DB::table('email_config')->where('status', '1')->where('id', '!=', $insertId)->update(['status' => '0']);
                    }

                    $status = '1';
                    $message = __('Email Settings has been saved successfully');
                } else {
                    $status = '0';
                    $message = __('Somethings wrong happened, we could not save settings into database.');
                }
            }

            DB::commit();
        } catch (Exception $e) {
            $status = '0';
            $message = $e->getMessage();
            DB::rollback();
        }

        return response()->json([
            'result' => $status,
            'message' => $message
        ]);
    }

    public function erase_email(Request $request)
    {
        if(config('settings.is_demo') == '1') abort(403);

        $table_id = $request->table_id;

        DB::table("email_config")->where("id", $table_id)->delete();
        echo '1';
    }

    public function set_session_active_tab(Request $request)
    {
        $link_id = $request->link_id;
        session(['general_settings_active_tab_id' => $link_id]);
    }

    public function get_email_config_info(Request $request)
    {
        $table_id = $request->table_id;

        $get_data = DB::table("email_config")->where('id', $table_id)->get();

        return response()->json([
            'result' => $get_data[0]
        ]);
    }

    public function lead_lists()
    {
        $data['body'] = 'leads.lists-lead';
        $data['load_datatable'] = true;

        return $this->viewcontroller($data);
    }

    public function lead_lists_data(Request $request)
    {
        $search_value = !is_null($request->input('search.value')) ? $request->input('search.value') : '';
        $display_columns = array('#', 'id', 'name', 'email', 'no_of_search', 'date_time', 'actions');
        $search_columns = array('name', 'email');

        $page = isset($request->page) ? intval($request->page) : 1;
        $start = isset($request->start) ? intval($request->start) : 0;
        $limit = isset($request->length) ? intval($request->length) : 10;
        $sort_index = !is_null($request->input('order.column')) ? strval($request->input('order.column')) : 1;
        $sort = !is_null($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'id';
        $order = !is_null($request->input('order.0.dir')) ? strval($request->input('order.0.dir')) : 'desc';
        $order_by = $sort . " " . $order;

        $table = "leads";
        $query = DB::table($table);
        if ($search_value != '') {
            $query->where(function ($query) use ($search_columns, $search_value) {
                foreach ($search_columns as $key => $value) $query->orWhere($value, 'like',  "%$search_value%");
            });
        }

        $info = $query->orderByRaw($order_by)->offset($start)->limit($limit)->get();

        $query = DB::table($table);
        if ($search_value != '') {
            $query->where(function ($query) use ($search_columns, $search_value) {
                foreach ($search_columns as $key => $value) $query->orWhere($value, 'like',  "%$search_value%");
            });
        }
        $total_result = $query->count();

        foreach ($info as $key => $value) {
            if(config('settings.is_demo') == '1') $value->email = '***************';
            $value->date_time = "<div>" . date("M j, Y h:i A", strtotime($value->date_time)) . "</div>";
            $value->actions = '<div><a data-bs-toggle="tooltip" title="' . __("Click to see domain lists") . '" href="#" class="btn btn-circle btn-primary see_domains" data-domains="' . $value->domain . '"><i class="fas fa-eye"></i></a></div>' . "<script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";
        }

        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = array_format_datatable_data($info, $display_columns, $start);
        echo json_encode($data);
    }


    public function ajax_export_contacts()
    {
        if (function_exists('ini_set')) {
            ini_set('memory_limit', '-1');
        }

        $leadLists = DB::table("leads")->orderBy('date_time', 'desc');

        $get_result = $leadLists->get();
        $count_result = $leadLists->count();

        $filename = date("d-m-Y") . "_lead_lists" . ".csv";
        $f = fopen('php://memory', 'w');
        fputs($f, "\xEF\xBB\xBF");
        $head = array("Name", "Email", "Last Updated", "Downloaded as guest : how many times?", "Domains");
        fputcsv($f, $head, ",");

        foreach ($get_result as $value) {
            $write_info = array();
            $write_info[] = $value->name;
            $write_info[] = $value->email;
            $write_info[] = $value->date_time;
            $write_info[] = $value->no_of_search;
            $write_info[] = $value->domain;
            fputcsv($f, $write_info, ',');
        }

        fseek($f, 0);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);
    }


    public function account()
    {
      $user = Auth::user();
      $data['body'] = 'admin/account';
      $data['data'] = $user;
      return $this->viewcontroller($data);
    }

    public function account_action(Request $request)
    {
        if(config('settings.is_demo') == '1') abort(403);
        
        $user_email = Auth::user()->email;
        $user_password = $request->password;
        $data['email'] = $request->email;
        $user_id = $this->user_id;

        $rules =
        [
            'name' => 'required|string|max:99',
            'mobile' => 'nullable|sometimes|string',
            'address' => 'nullable|sometimes|string',
            'timezone' => 'nullable|sometimes|string',
            'profile_pic'=>'nullable|sometimes|image|mimes:png,jpg,jpeg,webp|max:200'
        ];

        $logout=false;

        if($user_email != $data['email']){
            $rules['email'] = 'required|email|unique:users,email,' . $user_id;
            $logout = true;
        }

        if($user_password!=''){
            $rules['password'] = ['required','confirmed',Rules\Password::defaults()];
            $logout = true;
        }

        $validate_data = $request->validate($rules);
        if($user_email != $data['email']){
            $validate_data['email_verified_at'] = null;
        }

        if($request->file('profile_pic')) {

            $file = $request->file('profile_pic');
            $extension = $request->file('profile_pic')->getClientOriginalExtension();
            $filename ='sitedoc'.$user_id.'.'.$extension;
            $upload_dir_subpath = 'public/profile';

            // if(env('AWS_UPLOAD_ENABLED')){
            //    try {
            //        $upload2S3 = Storage::disk('s3')->putFileAs('profile', $file,$filename);
            //        $validate_data['profile_pic'] = Storage::disk('s3')->url($upload2S3);
            //    }
            //    catch (\Exception $e){
            //        $error_message = $e->getMessage();
            //    }
            // }
            // else{
                $request->file('profile_pic')->storeAs(
                    $upload_dir_subpath, $filename
                );
                $validate_data['profile_pic'] = asset('storage/app/public/profile').'/'.$filename;
            // }
        }

        if($user_password!='') $validate_data['password'] =  Hash::make($user_password);
        DB::table('users')->where('id',$user_id)->update($validate_data);

        if($logout) return redirect(route('logout'));

        $request->session()->flash('save_user_profile', '1');
        return redirect(route('account'));
    }
}
