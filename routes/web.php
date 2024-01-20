<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Settings;
use App\Http\Controllers\Js_controller;
use App\Http\Controllers\Domain;
use App\Http\Controllers\UpdateSystem;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Landing on Home
Route::controller(Home::class)->group(function() {
	Route::get('/', 'index');
});


// Dashboard
Route::group(['middleware'=>'auth',
			 'prefix'=>'dashboard',
			 'controller'=>Dashboard::class,
			 'as'=>'dashboard.'], function() {
	Route::get('/', 'index')->name('index');
});

// Settings set
Route::group(['middleware'=>'auth',
			'prefix'=>'settings',
			'controller'=>Settings::class,
			'as'=>'settings.'], function() {
	Route::get('/','index')->name('index');
	Route::post('save', 'settings_action')->name('save');
	Route::post('set-session-active-tab','set_session_active_tab')->name('session.tab');
	Route::post('email-lists','get_email_lists')->name('email.lists');
	Route::post('email','save_email_settings')->name('save.email');
	Route::post('email-update','get_email_config_info')->name('email.info');
	Route::post('erase-email','erase_email')->name('erase.email');
	Route::get('lead','lead_lists')->name('lead.lists');
	Route::post('lead','lead_lists_data')->name('lead.lists.data');
	Route::get('download/lead','ajax_export_contacts')->name('lead.list.download');
});

Route::group(['prefix'=>'get',
			'controller'=>Js_controller::class,
			'as'=>'get.'], function() {
	Route::post('ip','get_ip')->name('ip');
	Route::post('server/info','server_info')->name('server.info');
	Route::post('scroll/info','scroll_info')->name('scroll.info');
	Route::post('click/info','click_info')->name('click.info');
});

Route::group(['controller'=>Domain::class,
			'prefix'=>'domain',
			'as'=>'domain.'],function() {
	Route::get('download/pdf/{site_id}','report_pdf')->name('download.report');
	Route::get('download/comparative/pdf/{site_id}','comparision_report_pdf')->name('download.comparative.report');
	Route::any('report/{site_id?}/{site_name?}','report')->name('report');
	Route::any('comparison_report/{comparision_id?}','comparison_report')->name('comparison.report');
	Route::post('progress/count','progress_count')->name('progress.count');
	Route::post('search/action','search_action')->name('search');
	Route::any('report-pdf/send-download-link','send_download_link')->name('email.pdf');
	Route::any('comparison-report-pdf/send-download-link','send_download_link_comparision')->name('email.comparision.pdf');

	Route::get('sitehealth','site_health')->middleware(['auth'])->name('site.health');
	Route::post('sitehealth','site_health_data')->middleware(['auth'])->name('site.health.data');
	Route::get('comaparative/sitehealth','comparative_site_health')->middleware(['auth'])->name('comaparative.site.health');
	Route::post('comaparative/sitehealth','comparative_site_health_data')->middleware(['auth'])->name('comaparative.site.health.data');
	Route::post('domain/delete','delete_domain')->middleware(['auth'])->name('delete');
	Route::post('domains/delete','delete_selected_domain')->middleware(['auth'])->name('delete.selected');
});

//Account  

Route::get('settings/account',[Settings::class,'account'])->middleware(['auth'])->name('account');
Route::post('settings/account',[Settings::class,'account_action'])->middleware(['auth'])->name('account-action');


// Update System

Route::get('/update/site-doctor', [UpdateSystem::class,'update_list_v2'])->middleware(['auth'])->name('update-site-doctor');
// Route::get('/update/site-doctor/v2', [UpdateSystem::class,'update_list_v2'])->middleware(['auth'])->name('update-site-doctor-v2');
Route::any('/update_system/initialize_update', [UpdateSystem::class,'initialize_update'])->middleware(['auth'])->name('initialize-update');

Route::any('/installation-submit', [Home::class,'installation_submit'])->name('installation-submit');


Route::any('/privacy-policy', [Home::class,'privacy_policy'])->name('privacy-policy');
Route::any('/toc', [Home::class,'toc'])->name('toc');
Route::any('/refund-policy', [Home::class,'refund_policy'])->name('refund-policy');



Route::any('/home/important_feature', [Home::class,'important_feature'])->middleware(['auth'])->name('important-feature');
Route::any('/home/credential_check', [Home::class,'credential_check'])->middleware(['auth'])->name('credential-check');
Route::any('/home/credential_check/submit', [Home::class,'credential_check_action'])->middleware(['auth'])->name('credential-check-action');

require __DIR__.'/auth.php';
require __DIR__.'/agency.php';
