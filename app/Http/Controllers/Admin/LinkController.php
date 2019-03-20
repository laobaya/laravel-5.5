<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class LinkController extends CommonController
{


	//加载配置项
	public function __construct(Request $request){

		$this->request = $request;
		$this->CM = 'link';//声明控制器模板路径
		$this->PathArr = [];//声明访问文件

	}

	//加载后台首页
	public function index(){

		// dump($this->PathArr);
		return self::loadView();

	}


}
