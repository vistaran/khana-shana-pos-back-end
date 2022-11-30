<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
// User Token Api
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

// User APi
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'user',
    ],
    function ($router) {
        Route::get('show', 'UserController@show');
        Route::get('show/{id}', 'UserController@show_data');
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
        Route::get('show/{id}', 'OutletController@showDetail');
        Route::put('edit/{id}', 'OutletController@edit');
        Route::get('delete/{id}', 'OutletController@delete');
        Route::post('insert', 'OutletController@insert');
        Route::get('search', 'OutletController@search');
    }
);

// Category API
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'category',
    ],
    function ($router) {
        Route::get('show', 'CategoryController@show');
        Route::get('show/{id}', 'CategoryController@show_data');
        Route::put('edit/{id}', 'CategoryController@edit');
        Route::get('delete/{id}', 'CategoryController@delete');
        Route::post('insert', 'CategoryController@add');
        Route::get('search', 'CategoryController@search');
    }
);

// Attribute API
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'attribute',
    ],
    function ($router) {
        Route::get('show', 'AttributeController@show');
        Route::get('group_id', 'AttributeController@group_id');
        Route::get('show/{id}', 'AttributeController@show_data');
        Route::put('edit/{id}', 'AttributeController@edit');
        Route::get('delete/{id}', 'AttributeController@delete');
        Route::post('insert', 'AttributeController@insert');
        Route::get('search', 'AttributeController@search');
    }
);

// Attribute_family API
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'attribute_family',
    ],
    function ($router) {
        Route::get('show', 'AttributeFamilyController@show');
        Route::get('show/{id}', 'AttributeFamilyController@show_data');
        Route::put('edit/{id}', 'AttributeFamilyController@edit');
        Route::get('delete/{id}', 'AttributeFamilyController@delete');
        Route::post('insert', 'AttributeFamilyController@insert');
        Route::get('search', 'AttributeFamilyController@search');
    }
);

// Group API
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'group',
    ],
    function ($router) {
        Route::get('show', 'GroupController@show');
        Route::get('show/{id}', 'GroupController@show_data');
        Route::get('attribute_group_show', 'GroupController@attribute_group_show');
        Route::put('edit/{id}', 'GroupController@edit');
        Route::get('delete/{id}', 'GroupController@delete');
        Route::post('insert/{id}', 'GroupController@insert');
        Route::post('insertAttribute/{id}', 'GroupController@insertAttribute');
        Route::get('search', 'GroupController@search');
    }
);
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'expense_reports',
    ],
    function ($router) {
        Route::get('expense', 'ExpenseReportsController@show');
        Route::get('totalExpense', 'ExpenseReportsController@totalExpense');
        Route::get('showItem', 'ExpenseReportsController@showItem');
    }
);

// Product API
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'product',
    ],
    function ($router) {
        Route::get('last_position', 'ProductController@getLastPosition');
    }
);
Route::resource('product', ProductController::class);
// Route::get('product/last_position', [ProductController::class, 'getLastPosition'])->name('Position');
Route::resource('customer', CustomerController::class);
Route::resource('userAddress', UserAddresses::class);
Route::resource('vendors', VendorsController::class);
Route::resource('units', UnitsController::class);
Route::resource('purchase_items', PurchaseItemsController::class);
Route::resource('item_groups', ItemGroup::class);
Route::resource('purchase_order', PurchaseOrder::class);
Route::resource('orders', Orders::class);

Route::resource('tables_management', TablesManagementController::class);
Route::put('unoccupy_table/{id}', 'TablesManagementController@markAsUnoccupied');
Route::put('unoccupy_table_from_sales/{id}', 'Orders@unOccupyTableFromSales');

Route::get('qrcode', function () {
    // return QrCode::size(300)->format('png')->generate('http:://localhost:4200/sales/add_sale');
    return QrCode::generate('http://www.simplesoftware.io');
});
