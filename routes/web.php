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
Route::group(['prefix'=>'/','namespace'=>'Admin','middleware'=>['auth','power']],function(){

	//加载后台首页
	Route::GET('/', 'IndexController@index')->name('admin');

	// 加载后台welcome页
	Route::GET('welcome','IndexController@welcome');

	// 加载后台首页菜单
	Route::GET('left','IndexController@left');

	// 用户管理
	Route::group(['prefix'=>'user','middleware'=>[]],function(){

		Route::GET('/','UserController@index');
		Route::GET('{user}/edit','UserController@edit');
		

	});

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

	// 角色管理
	Route::group(['prefix'=>'role','middleware'=>[]],function(){

		Route::GET('/','RoleController@index');
		Route::GET('add','RoleController@add');
		Route::POST('add','RoleController@insert');
		Route::GET('{role}/edit','RoleController@edit');
		Route::POST('{role}/edit','RoleController@update');
		Route::POST('state','RoleController@state');



		// 规则
		Route::GET('rule','RoleController@rule');
		Route::GET('rule/create','RoleController@ruleadd');
		Route::POST('rule/create','RoleController@ruleinsert');
		Route::GET('rule/{rule}/edit','RoleController@ruleedit');
		Route::POST('rule/{rule}/edit','RoleController@ruleupdate');
		Route::DELETE('rule/{rule}','RoleController@ruledel');
	});


	//库存
	Route::group(['prefix'=>'ware','middleware'=>[]],function(){

		Route::GET('/','WareController@index');
		Route::PUT('/','WareController@update');
		Route::POST('/','WareController@update');
		Route::GET('add','WareController@add');
		Route::POST('add','WareController@insert');
		Route::POST('alldel','WareController@del');
		Route::POST('alltong','WareController@alltong');
		Route::DELETE('/', 'WareController@del');

		/*Route::GET('{ware}/edit','WareController@edit');
		Route::POST('{ware}/edit','WareController@update');
		Route::DELETE('{ware}', 'WareController@del');*/

		//详情
		Route::GET('{ware}/info','WareController@info');
		Route::GET('{ware}/info/add','WareController@infoadd');
		Route::POST('{ware}/info/add','WareController@infoinsert');
		Route::POST('{ware}/info','WareController@infoupdate');
		Route::DELETE('{ware}/info','WareController@infodel');
		Route::PUT('{ware}/info','WareController@infoupdate');

		Route::POST('{ware}/info/alldel','WareController@infoalldel');
		Route::POST('{ware}/info/alltong','WareController@infoalltong');

		// 列表页
		Route::GET('info','WareInfoController@index');
		Route::POST('info','WareInfoController@update');
		Route::PUT('info','WareInfoController@update');
		Route::GET('info/add','WareInfoController@add');
		Route::POST('info/alldel','WareInfoController@infoalldel');

		Route::POST('info/alltong','WareInfoController@infoalltong');
		Route::DELETE('{ware}/info','WareInfoController@infodel');


		Route::GET('type_add','WareController@typeadd');
		Route::POST('type_add','WareController@typeadd');
		Route::GET('product_add','WareController@productadd');
		Route::POST('product_add','WareController@product_add');
		Route::GET('{ware}/ware/product_add','WareController@productadd');
		Route::POST('{ware}/ware/product_add','WareController@product_add');

		
	});


	// 库存
	Route::group(['prefix'=>'inventory','middleware'=>[]],function(){

		Route::GET('/','InventoryController@index');

	});


});