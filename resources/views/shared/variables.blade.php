<?php
    if(!isset($is_admin)) $is_admin = '0';
    if(!isset($is_member)) $is_member = '0';

    $language = config('app.locale');
    $language_exp = explode('-', $language);
    $language_code = $language_exp[0] ?? 'en';
    $datatable_lang_file_path = public_path('assets').DIRECTORY_SEPARATOR.'vendors'.DIRECTORY_SEPARATOR.'datatables'.DIRECTORY_SEPARATOR.'language'.DIRECTORY_SEPARATOR.$language_code.'.json';
    if(file_exists($datatable_lang_file_path))
    $datatable_lang_file = asset('assets/vendors/datatables/language/'.$language_code.'.json');
    else $datatable_lang_file = asset('assets/vendors/datatables/language/en.json');
?>
<script type="text/javascript">
    var base_url = '{{url('/')}}';
    var site_url = base_url;
    var temp_route_variable = 1;
    var csrf_token = '{{ csrf_token() }}';
    var today = '{{ date("Y-m-d") }}';
    var is_admin = '{{$is_admin}}';
    var is_member = '{{$is_member}}';
    var route_name = '{{isset($route_name) && !empty($route_name) ? $route_name : ""}}';
    var language = '{{$language}}';
    var auth_user_id = '{{Auth::user()->id ?? ''}}';
    var auth_user_name = '{{Auth::user()->name ?? ''}}';
    var auth_user_email = '{{Auth::user()->email ?? ''}}';
    var auth_user_type = '{{Auth::user()->user_type ?? ''}}';

    var global_url_login = '{{ route('login') }}';
    var global_url_register = '{{ route('register') }}';
    var global_url_dashboard = '{{ route('dashboard.index') }}';
    var global_url_datatable_language = '{{$datatable_lang_file}}';

    var global_lang_loading = '{{ __('Loading') }}';
    var global_lang_sent = '{{ __('Sent') }}';
    var global_lang_required = '{{ __('Required') }}';
    var global_lang_ok = '{{ __('OK') }}';
    var global_lang_procced = '{{ __('Proceed') }}';
    var global_lang_success = '{{ __('Success') }}';
    var global_lang_warning = '{{ __('Warning') }}';
    var global_lang_error = '{{ __('Error') }}';
    var global_lang_confirm = '{{ __('Confirm') }}';
    var global_lang_create = '{{ __('Create') }}';
    var global_lang_edit = '{{ __('Edit') }}';
    var global_lang_delete = '{{ __('Delete') }}';
    var global_lang_clear_log = '{{ __('Clear Log') }}';
    var global_lang_cancel = '{{ __('Cancel') }}';
    var global_lang_apply = '{{ __('Apply') }}';
    var global_lang_understand = '{{ __('I Understand') }}';
    var global_lang_download = '{{ __('Download') }}';
    var global_lang_from = '{{ __('From') }}';
    var global_lang_to = '{{ __('To') }}';
    var global_lang_custom = '{{ __('Custom') }}';
    var global_lang_choose_data = '{{ __('Date') }}';
    var global_lang_last_30_days = '{{ __('Last 30 Days') }}';
    var global_lang_this_month = '{{ __('This Month') }}';
    var global_lang_last_month = '{{ __('Last Month') }}';
    var global_lang_something_wrong = '{{ __('Something went wrong.') }}';
    var global_lang_confirmation = '{{ __('Are you sure?') }}';
    var global_lang_delete_confirmation = '{{ __('Do you really want to delete this record? This action cannot be undone and will delete any other related data if needed.') }}';
    var global_lang_submitted_successfully = '{{ __('Data has been submitted successfully.') }}';
    var global_lang_saved_successfully = '{{ __('Data has been saved successfully.') }}';
    var global_lang_deleted_successfully = '{{ __('Data has been deleted successfully.') }}';
    var global_lang_action_successfully = '{{ __('Command action has been performed successfully.') }}';
    var global_lang_fill_required_fields = '{{ __('Please fill the required fields.') }}';
    var global_lang_check_status = '{{ __('Check Status') }}';
    var global_all_fields_are_required = '{{ __('All fields are required.') }}';
    var cancelcsvsubmission = '{{ __("Do you want to cancel this submission?") }}';
    var uploadCsvFile = '{{ __("Please upload your Subscribers CSV file") }}';
    var botIdNotFound = '{{ __("Please select a telegram bot") }}';
    var global_lang_export = '{{ __("Export") }}';
    var redirectToReport = "{{ __('you will be redirected to report page within few seconds') }}";
    var enterDomainName = "{{ __('you have not enter any website') }}";
    var searchCompleted = "{{ __('completed') }}";
    var youhavenotselectanydomain = "{{ __('you have not select any domain.') }}";
    var pleasewait = "{{ __('Please wait') }}";
    var step_completed = "{{ __('step completed') }}";

    var save_email_settings = '{{ route("settings.save.email") }}';
    var get_email_config_info = '{{ route("settings.email.info") }}';
    var erase_email_config_info = '{{ route("settings.erase.email") }}';
    var get_lead_lists = '{{ route("settings.lead.lists.data") }}';
    var get_ip = '{{ route("get.ip") }}';
    var server_info = '{{ route("get.server.info") }}';
    var scroll_info = '{{ route("get.scroll.info") }}';
    var click_info = '{{ route("get.click.info") }}';
    var healthCheckAction = '{{ route("domain.search") }}';
    var progressCount = '{{ route("domain.progress.count") }}';
    var comparisonReport = '{{ route("domain.comparison.report") }}';
    var siteReport = '{{ route("domain.report") }}';
    var siteHealthData = '{{ route("domain.site.health.data") }}';
    var comparativeSiteHealthData = '{{ route("domain.comaparative.site.health.data") }}';
    var delete_selected_domains = '{{ route("domain.delete.selected") }}';
    var delete_domain = '{{ route("domain.delete") }}';
    var purchase_code_active = '{{ route("credential-check-action") }}'

    <?php if(check_is_mobile_view()) echo 'var areWeUsingScroll = false;';
    else echo 'var areWeUsingScroll = true;';?>
</script>

