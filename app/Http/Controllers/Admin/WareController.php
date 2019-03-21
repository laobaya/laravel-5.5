<?php

namespace App\Http\Controllers\Admin;

use App\Model\Ware;
use Illuminate\Http\Request;

class WareController extends CommonController
{


	//加载配置项
	public function __construct(Request $request,Ware $ware){

		$this->request = $request;
		$this->CM = 'ware';//声明控制器模板路径
		$this->PathArr = ['index'=>'index','add'=>'add','info'=>'info','edit'=>'edit'];//声明访问文件
		$this->model = $ware;//加载model类

	}

	//加载后台首页
	public function index(){

		$toload = $this->model->wareIndex($this->request);
		// dump($toload);
		return self::loadView($toload);

	}

	//加载添加页面
	public function add(){

		return self::loadView();

	}

	// 插入数据
	public function insert(){

		$data = $this->request->except(['_token']);
        $result = $this->model->wareInsert($data);
        return $result;
	}


	//查看详情
	public function info(Ware $ware){

		$toload = $ware->wareInfo()->get();
		dump($toload);
		return self::loadView($toload);

	}

	public function edit(Ware $ware){

		$toload = $ware->wareEdit();
		return self::loadView($toload);
	}


	public function del(){
		
	}
}
