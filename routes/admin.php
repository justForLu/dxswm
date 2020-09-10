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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/index');
});
Route::get('admin', function () {
    return redirect('/admin/index');
});
Route::get('/getImg/{id}/{w?}/{h?}', function ($id,$w,$h) {
    return redirect()->route('getImg', ['id'=>$id,'w'=>$w,'h'=>$h]);
});



Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function (){

    Route::get('/login', 'LoginController@index');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');
    Route::get('/getImg/{id}/{w?}/{h?}', ['as' => 'getImg', 'uses' => 'FileController@getImg']);

    Route::group(['middleware' => ['admin.auth','admin.log']], function(){
        Route::get('/index', 'IndexController@index');

        Route::resource('/manager', 'ManagerController');
        Route::resource('/permission', 'PermissionController');
        Route::resource('/menu', 'MenuController');
        Route::resource('/role', 'RoleController');
        Route::resource('/log', 'LogController');
        Route::match(['get', 'post'],'/role/authority/{id?}', 'RoleController@authority');
        Route::post('/file/uploadPic','FileController@uploadPic');
        Route::post('/file/uploadFile','FileController@uploadFile');
        Route::resource('/category', 'CategoryController');
        Route::get('/category/getCategory/{type}', 'CategoryController@getCategory');
        Route::resource('/config', 'ConfigController');
        Route::resource('/feedback', 'FeedbackController');
    });
});
