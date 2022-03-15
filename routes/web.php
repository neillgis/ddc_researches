<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();

    // Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', function () {
    return redirect('keycloak/login');
    // return view('welcome');
});

Route::group(['middleware' => 'keycloak-web'], function () {
    // -- Log Viewer --
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index') -> name('page.logs');
    // -- keycloak/demo --
    Route::get('/keycloak/demo','KeycloakDemoController@index') -> name('page.keycloak.demo');
    // -- DASHBOARD --
    Route::get('/dashboard','DashboardController@dash_index')->name('page.dashboard');


    Route::get('/profile','ProfileController@index')->name('page.profile');
    //  -- INSERT --
    Route::post('/profile_insert','ProfileController@insert')->name('profile.insert');
    //  -- UPDATE PROFILE --
    Route::post('profile/update', 'ProfileController@save_update_profile')->name('profile.save');


    // FORM  RESEARCH  PROJECT
    // Route::get('/research_form','ResearchController@research')->name('page.research');
    Route::get('/research_form','ResearchController@table_research')->name('page.research');
    //  -- INSERT --
    Route::post('/research_insert','ResearchController@insert')->name('research.insert');
    //  -- EDIT --
    Route::get('/research_edit/{id}','ResearchController@edit_research_form')->name('research.edit');
    //  -- SAVE --
    Route::post('/save_research_edit','ResearchController@save_research_form')->name('research.save');
    //  -- DOWNLOAD --
    Route::get('/Download-Files/research/{id}/{files}','ResearchController@DownloadFile')->name('DownloadFile.research');
    //  -- VERIFIED --
    Route::post('/research/verified', 'ResearchController@action_verified')->name('research.verified');
    //  -- NO VERIFIED --
    Route::get('/research/unverified/{id}', 'ResearchController@No_verified')->name('research.unverified');
    //  -- DELETE --
    Route::get('/Delete-Research/{id}', 'ResearchController@delete_research')->name('research.delete');
    //  -- COMMENTS for "MANAGER" --
    Route::post('/research/comments', 'ResearchController@action_comments_manager')->name('research.comments');
    //  -- COMMENTS for "USER" --
    Route::post('/research/comments-users', 'ResearchController@action_comments_users')->name('research.comments_users');



    // FORM  JOURNAL
    // Route::get('/journal_form','JournalController@journal')->name('page.journal');
    Route::get('/journal_form','JournalController@table_journal')->name('page.journal');
    //  -- INSERT --
    Route::post('/journal_insert','JournalController@insert')->name('journal.insert');
    //  -- EDIT --
    Route::get('/journal_edit/{id}/{pro_id}','JournalController@edit_journal_form')->name('journal.edit');
    //  -- EDIT --
    Route::get('/journal_edit/{id}','JournalController@edit2_journal_form')->name('journal.edit2');
    //  -- SAVE --
    Route::post('/save_journal_edit','JournalController@save_journal_form')->name('journal.save');
    //  -- DOWNLOAD --
    Route::get('/Download-Files/journal/{id}/{files}','JournalController@DownloadFile')->name('DownloadFile.journal');
    //  -- VERIFIED --
    Route::post('/journal/verified', 'JournalController@action_verified')->name('journal.verified');
    //  -- NO VERIFIED --
    Route::get('/journal/unverified/{id}', 'JournalController@No_verified')->name('journal.unverified');
    //  -- DELETE --
    Route::get('/Delete-Journal/{id}', 'JournalController@delete_journal')->name('journal.delete');
    //  -- STATUS --
    Route::post('/journal/status', 'JournalController@status_journal')->name('journal.status');



    // FORM  ULTILIZATION
    // Route::get('/util_form','UtilizationController@util') -> name('page.util');
    Route::get('/util_form','UtilizationController@table_util') -> name('page.util');
    //  -- INSERT --
    Route::post('/util_insert','UtilizationController@insert') -> name('util.insert');
    //  -- EDIT --
    Route::get('/util_edit/{id}','UtilizationController@edit_util') -> name('util.edit');
    //  -- SAVE --
    Route::post('/save_util_edit','UtilizationController@save_util') -> name('util.save');
    //  -- DOWNLOAD --
    Route::get('/Download-Files/util/{id}/{files}','UtilizationController@DownloadFile')->name('DownloadFile.util');
    //  -- VERIFIED --
    Route::post('/util/verified', 'UtilizationController@action_verified')->name('util.verified');
    //  -- NO VERIFIED --
    Route::get('/util/unverified/{id}', 'UtilizationController@No_verified')->name('util.unverified');
    //  -- DELETE --
    Route::get('/Delete-Utilization/{id}', 'UtilizationController@delete_util')->name('util.delete');
    //  -- STATUS --
    Route::post('/util/status', 'UtilizationController@status_util')->name('util.status');



    // -- FAQ --
    Route::get('/faq','FaqController@faq_index')->name('page.faq');


    // FORM  SUMMARY
    // Route::get('/summary_form','SummaryController@summary') -> name('page.summary');
    Route::get('/summary_form','SummaryController@table_summary') -> name('page.summary');
    //  -- INSERT --
    Route::post('/summary_insert','SummaryController@insert_summary') -> name('summary.insert');
    //  -- EDIT --
    Route::get('/summary_edit/{id}','SummaryController@edit_summary') -> name('summary.edit');
    //  -- SAVE --
    Route::post('/save_summary_edit','SummaryController@save_summary') -> name('summary.save');
    //  -- DOWNLOAD --
    Route::get('/Download-Files/summary/{id}/{files}','SummaryController@DownloadFile')->name('DownloadFile.summary');
    //  -- VERIFIED --
    Route::post('/summary/verified', 'SummaryController@auditor_verified')->name('summary.verified');



    // EXPORT File CSV
    Route::get('export_research', 'ExportController@export_research')->name('export_research');

    Route::get('export_journal', 'ExportController@export_journal')->name('export_journal');

    Route::get('export_util', 'ExportController@export_util')->name('export_util');



    // Users-Manage for "ADMIN"
    Route::get('/users-manage', 'UsersManageController@users_manage')->name('admin.users_manage');
    // Delete-users
    Route::get('/users-manage-delete/{users_id}', 'UsersManageController@users_manage_delete')->name('admin.users_manage_delete');



    // ------- ALERT Notifications -------
    Route::get('/all-notifications', 'UpdateNotifyController@notifications_all')->name('all.notify');
    // Redirect to Message
    Route::get('/redirect-url-notifications', 'UpdateNotifyController@redirect_url')->name('redirect.url');
    //  -- DOWNLOAD File --
    Route::get('/download-files/notify/{id}/{files_upload}','UpdateNotifyController@DownloadFile_Notify')->name('DownloadFile.Notify');



    Route::get('dynamic_field', 'DynamicFieldUtilController@index');
    Route::post('dynamic_field/insert', 'DynamicFieldUtilController@insert')->name('dynamic-field.insert');

  });
