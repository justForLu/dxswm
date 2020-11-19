<?php
header('access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:Content-Type,Access-Token,Access-Control-Allow-Origin');
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

Route::get('home', function () {
    return redirect('/home/index');
});


Route::group(['prefix' => 'api', 'namespace' => 'Api'], function (){

    Route::get('/index', 'IndexController@index');
    Route::get('/index/school', 'IndexController@school');
    Route::get('/index/get_config', 'IndexController@getConfig');
    Route::get('/index/get_token', 'IndexController@getCsrfToken');

    Route::get('/school/get_list','SchoolController@getList');

    Route::get('/city/get_list','CityController@getList');

    Route::get('/business/get_list','BusinessController@getList');


    Route::get('/goods/get_list','GoodsController@getList');

    Route::group(['middleware' => ['api.auth']], function(){
        Route::get('/business/get_info','BusinessController@getInfo');

        Route::get('/category/get_list','CategoryController@getList');
        Route::get('/category/get_cat_goods','CategoryController@getCatGoods');

        Route::get('/cart/get_cart', 'CartController@getCart');
        Route::post('/cart/add_cart', 'CartController@addCart');
        Route::post('/cart/empty_cart', 'CartController@emptyCart');

        Route::get('/order/get_list','OrderController@getList');
        Route::post('/order/create_order','OrderController@createOrder');
        Route::post('/order/submit_order','OrderController@submitOrder');
        Route::post('/order/pay_order','OrderController@payOrder');
        Route::post('/order/confirm_order','OrderController@confirmOrder');
        Route::post('/order/evaluate_order','OrderController@evaluateOrder');

        Route::get('/address/get_list','AddressController@getList');
        Route::post('/address/save_address','AddressController@saveAddress');
        Route::get('/address/get_info','AddressController@getInfo');
        Route::post('/address/upd_address','AddressController@updAddress');
    });
});


