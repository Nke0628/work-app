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

/**
 * トップページ
 */
Route::get('/', 'IndexController@index');

/**
 * auth
 */
Route::get('/signup', 'Auth\RegisterController@showRegistrationForm');
Route::post('/signup', 'Auth\RegisterController@register');
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');

/**
 * 勤怠区分
 */
Route::get('/master/work_division', 'Master\WorkDivision\WorkDivisionController@showList');
Route::post('/master/work_division/ajax/submit', 'Master\WorkDivision\WorkDivisionController@registerWorkDivision');
Route::post('/master/work_division/ajax/resubmit', 'Master\WorkDivision\WorkDivisionController@updateWorkDivision');
Route::post('/master/work_division/ajax/delete', 'Master\WorkDivision\WorkDivisionController@deleteWorkDivision');
Route::post('/master/work_division/ajax/upload', 'Master\WorkDivision\WorkDivisionController@getPreviewHtml');
Route::post('/master/work_division/ajax/upload/save', 'Master\WorkDivision\WorkDivisionController@saveCsvData');


