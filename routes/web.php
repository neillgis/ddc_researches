<?php

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
    return view('welcome');
});


Route::get('/home','MainController@index') -> name('page.home');
Route::get('/dashboard','MainController@dashboard') -> name('page.dashboard');


// FORM  MEMBER
Route::get('/member_form','MemberController@member') -> name('page.member');
// FORM  MEMBER  -- INSERT
// Route::post('/member_insert','MemberController@insert') -> name('member.insert');


// FORM  RESEARCH  PROJECT
Route::get('/research_form','ResearchController@research') -> name('page.research');
Route::get('/research_form','ResearchController@index2') -> name('page.research');

Route::post('/research_insert','ResearchController@insert') -> name('research.insert');




// FORM  PUBLISHED  JOURNAL
Route::get('/journal_form','JournalController@journal') -> name('page.journal');
// FORM  PUBLISHED  JOURNAL  -- INSERT
// Route::post('/journal_insert','JournalController@insert') -> name('journal.insert');


// FORM  ULTILIZATION
Route::get('/util_form','UtilizationController@util') -> name('page.util');
// FORM  ULTILIZATION  -- INSERT
// Route::post('/util_insert','UtilizationController@insert') -> name('util.insert');
