<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AuthController;

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
    'prefix' => 'auth'

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
        'prefix' => 'user'
    ],
    function ($router) {
        Route::get('add', 'UserController@add');
        Route::get('edit/{id}', 'UserController@edit');
        Route::get('delete/{id}', 'UserController@delete');
    }
);




// Outlets Api
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'outlet'
    ],
    function ($router) {
        Route::get('show', 'OutletController@show');
        Route::get('edit/{id}', 'OutletController@edit');
        Route::get('delete/{id}', 'OutletController@delete');
        Route::get('insert', 'OutletController@insert');
    }
);
