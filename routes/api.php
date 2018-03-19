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

Route::prefix('e1')->namespace('E1')->group(function () {
    Route::prefix('account')->group(function () {
        Route::get('{guid}/balance', 'AccountController@balance');
        Route::get('{guid}/details', 'AccountController@details');
    });

    Route::prefix('customer')->group(function () {
        Route::get('debt', 'CustomerController@debt');
        Route::get('account/{guid}', 'CustomerController@account');
    });
});

Route::prefix('e2')->namespace('E2')->group(function () {
    Route::prefix('account')->group(function () {
        Route::get('{guid}/balance', 'AccountController@balance');
        Route::get('{guid}/details', 'AccountController@details');
    });

    Route::prefix('customer')->group(function () {
        Route::get('{id}/debt', 'CustomerController@debt');
        Route::get('{id}/account/{guid}', 'CustomerController@account');
    });
});

Route::prefix('e3')->namespace('E3')->group(function () {
    Route::prefix('customer')->group(function () {
        Route::get('{id}/search', 'CustomerController@search');
        Route::get('{id}/balances', 'CustomerController@balances');
    });
});