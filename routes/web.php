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
	Route::get('/', 'IndexController@index')->name('admin');

	// 加载后台welcome页
	Route::get('welcome','IndexController@welcome');

	// 加载后台首页菜单
	Route::get('left','IndexController@left');


	// 菜单管理
	Route::group(['prefix'=>'menu','middleware'=>[]],function(){


		Route::get('/','MenuController@index');
		/*Route::post('menudel/{v}', 'MenuController@menudel');
		Route::put('menuorder', 'MenuController@menuorder');
		Route::put('menustate', 'MenuController@menustate');
		Route::post('menudelall', 'MenuController@menudelall');
		Route::get('menu/{menu}/add', 'MenuController@menuadd');
		Route::post('menu/{menu}/add', 'MenuController@menuinsert');*/

	});

});