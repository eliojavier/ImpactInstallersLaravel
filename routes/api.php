<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auth::routes();

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//
//});

Route::post('users', 'UserController@store');

//Route::group(['middleware' => 'auth:api'], function () {
Route::get('users/available/{date}/{time}', 'UserController@getAvailableUsers');
Route::put('users/password/{user}', 'UserController@resetPassword');
Route::put('assignments/status/{assignment}', 'AssignmentController@updateStatus');
Route::resource('users', 'UserController', ['except' => 'store']);
Route::resource('assignments', 'AssignmentController');
Route::resource('locations', 'LocationController');
Route::resource('bills', 'BillController');
Route::get('make-invoice', 'BillController@makeInvoice');
Route::get('reports/rankingLocations', 'ReportsController@rankingLocations');
Route::get('reports/rankingInstallers', 'ReportsController@rankingInstallers');
Route::get('reports/rankingCommissions/{month}/{year}', 'ReportsController@rankingCommissions');

//});



