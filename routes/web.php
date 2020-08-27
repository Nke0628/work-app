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
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');

/**
 * 組織設定
 */

Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
    Route::get('/department', 'Department\SearchDepartmentController@searchDepartment');
    Route::get('/department/register', 'Department\DepartmentController@showRegisterDepartmentForm');
    Route::post('/department/register', 'Department\DepartmentController@registerDepartment');
});

/**
 * 勤怠区分
 */
Route::get('/master/work_division', 'Master\WorkDivision\WorkDivisionController@showList');
Route::post('/master/work_division/ajax/submit', 'Master\WorkDivision\WorkDivisionController@registerWorkDivision');
Route::post('/master/work_division/ajax/resubmit', 'Master\WorkDivision\WorkDivisionController@updateWorkDivision');
Route::post('/master/work_division/ajax/delete', 'Master\WorkDivision\WorkDivisionController@deleteWorkDivision');
Route::post('/master/work_division/ajax/upload', 'Master\WorkDivision\WorkDivisionController@getPreviewHtml');
Route::post('/master/work_division/ajax/upload/save', 'Master\WorkDivision\WorkDivisionController@saveCsvData');

/**
 * CSV
 */
Route::get('/csv', 'Csv\CsvController@showCsv');
Route::post('/csv/upload', 'Csv\CsvController@uploadCsv');


