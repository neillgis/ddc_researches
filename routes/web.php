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
    Route::get('/keycloak/demo','KeycloakDemoController@index') -> name('page.keycloak.demo');

    Route::get('/profile','ProfileController@index') -> name('page.profile');

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
    Route::get('/research/verified/{id}', 'ResearchController@action_verified')->name('research.verified');



    // FORM  JOURNAL
    // Route::get('/journal_form','JournalController@journal')->name('page.journal');
    Route::get('/journal_form','JournalController@table_journal')->name('page.journal');
    //  -- INSERT --
    Route::post('/journal_insert','JournalController@insert')->name('journal.insert');
    //  -- EDIT --
    Route::get('/journal_edit/{id}/{pro_id}','JournalController@edit_journal_form')->name('journal.edit');
    //  -- SAVE --
    Route::post('/save_journal_edit','JournalController@save_journal_form')->name('journal.save');
    //  -- DOWNLOAD --
    Route::get('/Download-Files/journal/{id}/{files}','JournalController@DownloadFile')->name('DownloadFile.journal');
    //  -- VERIFIED --
    Route::get('/journal/verified/{id}', 'JournalController@action_verified')->name('journal.verified');



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
    Route::get('/util/verified/{id}', 'UtilizationController@action_verified')->name('util.verified');



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




    Route::get('dynamic_field', 'DynamicFieldUtilController@index');
    Route::post('dynamic_field/insert', 'DynamicFieldUtilController@insert')->name('dynamic-field.insert');

  });
