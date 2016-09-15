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

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    //Route::auth();

    Route::get('/', 'HomeController@welcome');
    Route::get('/add', 'HomeController@add');
});

//item's pic upload
Route::post('additemupload', 'uploadController@imgupload');
Route::post('additemdelete', 'uploadController@imgDelete');

Route::controller('cart', 'CartController');
//Route::get('showcustom', 'CartController@showCustom')->name('a/b'); //use new method to route controller and action related cart
