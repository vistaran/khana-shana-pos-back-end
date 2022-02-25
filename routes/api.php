<?php

use Illuminate\Support\Facades\Route;

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
//User Token Api
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

//User APi
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'user',
    ],
    function ($router) {
        Route::get('show', 'UserController@show');
        Route::post('insert', 'UserController@add');
        Route::put('edit/{id}', 'UserController@edit');
        Route::get('delete/{id}', 'UserController@delete');
        Route::get('search', 'UserController@Search');
    }
);

// Outlets Api
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'outlet',
    ],
    function ($router) {
        Route::get('show', 'OutletController@show');
        Route::put('edit/{id}', 'OutletController@edit');
        Route::get('delete/{id}', 'OutletController@delete');
        Route::post('insert', 'OutletController@insert');
        Route::get('search', 'OutletController@search');
    }
);

//Category API
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'category',
    ],
    function ($router) {
        Route::get('show', 'CategoryController@show');
        Route::put('edit/{id}', 'CategoryController@edit');
        Route::get('delete/{id}', 'CategoryController@delete');
        Route::post('insert', 'CategoryController@add');
        Route::get('search', 'CategoryController@search');
    }
);
