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

Route::GET('logout','Auth\LoginController@logout');


Route::get('errorrule',function () {
    return view('errorrule');
})->name('errorrule');//错误页面
Route::get('fxa',function () {
    return view('fxa');
})->name('fxa');//错误页面

//后台路由
Route::group(['prefix'=>'/','namespace'=>'Admin','middleware'=>['auth','fxa']],function(){

	//加载后台首页
	Route::GET('/', 'IndexController@index')->name('admin');

	// 加载后台welcome页
	Route::GET('welcome','IndexController@welcome');

	// 加载后台首页菜单
	Route::GET('left','IndexController@left');

	// 用户管理
	Route::group(['prefix'=>'user','middleware'=>['power']],function(){

		Route::GET('/','UserController@index');
		Route::DELETE('{user}','UserController@del');
		Route::POST('{user}/edit','UserController@edit');
		Route::POST('state','UserController@state');
		Route::GET('{user}/role','UserController@role');
		Route::POST('{user}/role','UserController@role');
		Route::GET('changepassword','UserController@password');
		Route::POST('changepassword','UserController@password');
		Route::GET('resetpassword','UserController@resetpassword');
		

	});

	// 菜单管理
	Route::group(['prefix'=>'menu','middleware'=>['power']],function(){

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
	Route::group(['prefix'=>'role','middleware'=>['power']],function(){

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
	Route::group(['prefix'=>'ware','middleware'=>['power']],function(){

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



		// 添加库存类型
		Route::GET('type_add','OperationController@typeadd');
		Route::POST('type_add','OperationController@typeadd');
		//添加库存类型
		//添加产品
		Route::GET('info/product_add','ProductController@productadd');
		Route::POST('info/product_add','ProductController@productadd');
		Route::GET('{ware}/info/product_add','ProductController@productadd');
		Route::POST('{ware}/info/product_add','ProductController@productadd');
		//添加产品
			
	});


	// 库存
	Route::group(['prefix'=>'inventory','middleware'=>['power']],function(){

		Route::GET('/','InventoryController@index');
		Route::GET('{id}/info','InventoryController@show');
		Route::GET('{id}/info/{date}','InventoryController@showInfo');

	});

	//产品管理
	Route::group(['prefix'=>'product','middleware'=>['power']],function(){

		Route::GET('/','ProductController@index');
		Route::GET('add','ProductController@productadd');
		Route::POST('add','ProductController@productadd');
		Route::POST('/','ProductController@update');
		Route::DELETE('/','ProductController@del');
		

	});

	// 库存类型运算
	Route::group(['prefix'=>'operation','middleware'=>['power']],function(){


		Route::GET('/','OperationController@index');
		Route::PUT('/','OperationController@update');
		Route::POST('/','OperationController@update');
		Route::DELETE('/','OperationController@del');
		Route::GET('add','OperationController@typeadd');
		Route::POST('add','OperationController@typeadd');
	});


	// 竞价管理
	Route::group(['prefix'=>'bidding','middleware'=>['power']],function(){

		Route::group(['prefix'=>'rush'],function(){

			Route::GET('/','BiddingController@rushIndex');

		
		});
	});
});