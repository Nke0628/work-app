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

/** 勤怠区分マスタ */
Route::get('/master/work_division', 'Master\WorkDivision\WorkDivisionController@showList');
Route::post('/master/work_division/ajax/submit', 'Master\WorkDivision\WorkDivisionController@registerWorkDivision');
Route::post('/master/work_division/ajax/resubmit', 'Master\WorkDivision\WorkDivisionController@updateWorkDivision');
Route::post('/master/work_division/ajax/delete', 'Master\WorkDivision\WorkDivisionController@deleteWorkDivision');
