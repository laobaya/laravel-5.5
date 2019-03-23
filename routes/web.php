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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('/');

//后台路由
Route::group(['prefix'=>'/','namespace'=>'Admin','middleware'=>[]],function(){

	//加载后台首页
	Route::GET('/', 'IndexController@index')->name('admin');

	// 加载后台welcome页
	Route::GET('welcome','IndexController@welcome');

	// 加载后台首页菜单
	Route::GET('left','IndexController@left');


	// 菜单管理
	Route::group(['prefix'=>'menu','middleware'=>[]],function(){

		Route::GET('/','MenuController@index');
		Route::GET('{menu}/add', 'MenuController@add');
		Route::POST('{menu}/add', 'MenuController@insert');
		Route::GET('{menu}/edit', 'MenuController@edit');
		Route::POST('{menu}/edit', 'MenuController@update');
		Route::DELETE('{menu}', 'MenuController@del');
		Route::PUT('{menu}', 'MenuController@state');
		Route::POST('{menu}', 'MenuController@order');

	});

	// 友情链接
	Route::group(['prefix'=>'mylink','middleware'=>[]],function(){



	});


	//库存
	Route::group(['prefix'=>'ware','middleware'=>[]],function(){

		Route::GET('/','WareController@index');
		Route::GET('add','WareController@add');
		Route::POST('add','WareController@insert');
		Route::GET('{ware}/edit','WareController@edit');
		Route::POST('{ware}/edit','WareController@update');
		Route::DELETE('{ware}', 'WareController@del');
		//详情
		Route::GET('{ware}/info','WareController@info');
		Route::GET('{ware}/info/add','WareController@infoadd');



	});

});