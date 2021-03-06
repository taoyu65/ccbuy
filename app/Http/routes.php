
<?php

Event::listen('404', function() {
    return Response::error('404');
});
Event::listen('401', function() {
    return Response::error('401');
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
    Route::get('/', function(){
        return view('cc_admin/login');
    });


    /*
    |--------------------------------------------------------------------------
    | login
    |--------------------------------------------------------------------------
    */
    Route::group(array('prefix' => 'cc_admin'), function(){
        #login page
        Route::get('login', function(){
            return view('cc_admin/login');
        });
        #loging in
        Route::post('submit', 'UserController@submit');
    });
    /*
    |--------------------------------------------------------------------------
    | set language
    |--------------------------------------------------------------------------
    */
    Route::get('setLanguage/{lang}', function($lang){
        session(['lang' => $lang]);
        return redirect()->back();
    });
    /*
    |--------------------------------------------------------------------------
    | get demo (if demo login than will be transferred to separate database)
    |--------------------------------------------------------------------------
    */
    Route::get('type/{demo}', 'UserController@demo');
    /*
    |--------------------------------------------------------------------------
    | Auth : pages need to be logged in
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'auth'], function () {

        #default page
        Route::get('firstpage', 'ItemController@firstPage');
        #statistics
        Route::get('statistics/{x}/{y}/{refresh?}', 'statisticController@index');
        Route::get('statisticsAllItem/{refresh?}', 'statisticController@allItem');
        #customs
        Route::get('showcustomwindow', 'CustomController@showWindow');
        Route::post('addcustom', 'CustomController@add');
        Route::get('getcustomname/{id}','CustomController@getCustomName');
        #item
        Route::resource('item', 'ItemController');
        Route::get('item/create/daimai', 'ItemController@daiMai');
        Route::get('getItems/{id}', 'ItemController@getItems');
        #store
        Route::resource('store', 'StoreController');
        #cart
        Route::get('showcart/{daimai?}', 'CartController@showCustomList');
        Route::post('addcart','CartController@add');
        Route::get('searchCart/{custom?}', 'CartController@search');
        #item's pic upload
        Route::post('additemupload', 'UploadController@imgupload');
        Route::post('additemdelete', 'UploadController@imgDelete');
        #get paid -marked is deal and finish cart
        Route::get('collecting', 'CartController@unFinishDeal');
        Route::group(array('prefix' => 'cc_admin'), function() {
            Route::get('main', function(){
                return view('cc_admin/main');
            });
            Route::get('system', 'ccAdminController@closeCartShow');    //结算订单 close cart, recalculate profits
            Route::post('system/close', 'ccAdminController@closeCart');
            Route::get('table/{name}', 'ccTableController@showTable');
            Route::match(['get','post'],'table/{name}/search/{tab}', 'ccTableController@search');
            #edit
            Route::get('tableEdit/{tableName}/{id}', 'ccTableController@editShow');
            Route::post('tableEdit/{tableName}/{id}', 'ccTableController@edit');
            #delete
            Route::get('tableDelete/{tableName}/{id}', 'ccTableController@deleteShow');
            Route::post('delete', 'ccTableController@delete');
            #logout
            Route::get('logout', 'UserController@logout');
        });
    });
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
});
