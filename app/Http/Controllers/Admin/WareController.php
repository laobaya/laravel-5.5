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
		$this->PathArr = ['index'=>'index','add'=>'add','info'=>'info','edit'=>'edit','infoadd'=>'infoadd'];//声明访问文件
		$this->model = $ware;//加载model类

	}

	//加载后台首页
	public function index(){

		$data = $this->request->except(['_token']);
		$toload = $this->model->wareIndex($data);
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


	public function edit(Ware $ware){

		$toload = $ware->wareEdit();
		// dump($toload);
		return self::loadView($toload);
	}

	public function update(Ware $ware){

		$data = $this->request->except(['_token','_method']);
   		$result = $ware->wareUpdate($data);
        return $result;

	}

	public function del(Ware $ware){
		// dump($ware);
		$result = $ware->wareDel();
   		return $result;
	}


	//查看详情
	public function info(Ware $ware){

		// dump($toload);

		$is_data = $this->request->input('data');
		//判断是否是调用数据
		if($is_data){
			$data = $this->request->input();
			$result = $ware->wareInfos($data);
			return $result;
		}

		return self::loadView();

	}

	public function infoadd(Ware $ware){

		return self::loadView();

	}

}
