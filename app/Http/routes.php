<?php

Event::listen('404', function() {
    return Response::error('404');
});
$router->pattern('id', '[0-9]+');
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    //Route::auth();

    //Route::get('/add', 'HomeController@add');
    //Route::get('', 'ItemController@create');
    Route::get('', 'HomeController@welcome');
    Route::get('firstpage', 'ItemController@firstPage');
    //customs
    Route::get('showcustomwindow', 'CustomController@showWindow');
    Route::post('addcustom', 'CustomController@add');
    Route::get('getcustomname/{id}','CustomController@getCustomName');

    //item
    Route::resource('item', 'ItemController');

    //store
    Route::resource('store', 'StoreController');

    //cart
    Route::get('showcart', 'CartController@showCustomList');
    Route::post('addcart','CartController@add');
    Route::get('searchCart/{custom?}', 'CartController@search');

    //item's pic upload
    Route::post('additemupload', 'UploadController@imgupload');
    Route::post('additemdelete', 'UploadController@imgDelete');

    Route::auth();
    Route::get('/home', 'HomeController@index');
});
