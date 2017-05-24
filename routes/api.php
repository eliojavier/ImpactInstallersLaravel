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

    Route::resource('users', 'UserController', ['except'=>'store']);
    Route::resource('assignments', 'AssignmentController');
    Route::resource('locations', 'LocationController');
    Route::resource('bills', 'BillController');
    Route::get('make-invoice', 'BillController@makeInvoice');

//});



