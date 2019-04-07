<?php

namespace App\Http\Controllers\Admin;

use App\Model\Ware;
use App\Model\WareOperation;
use App\Model\Product;
use Illuminate\Http\Request;

class WareController extends CommonController
{


	//加载配置项
	public function __construct(Request $request,Ware $ware){

		$this->request = $request;
		$this->CM = 'ware';//声明控制器模板路径
		$this->PathArr = ['index'=>'1index','add'=>'add','info'=>'info','edit'=>'edit','infoadd'=>'infoadd'];//声明访问文件
		$this->model = $ware;//加载model类

	}

	//加载后台首页
	public function index(){

		$is_data = $this->request->input('data');
		//判断是否是调用数据
		if($is_data){

			$data = $this->request->input();
			$result = $this->model->wareIndex($data);
			return $result;
		}

		return self::loadView();

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

	//改版1.0
	/*public function edit(Ware $ware){

		$toload = $ware->wareEdit();
		// dump($toload);
		return self::loadView($toload);
	}*/

	//结束改版1.0

	public function update(){


		/*$data = $this->request->except(['_token','_method']);
   		$result = $ware->wareUpdate($data);
        return $result;*/

        $data = $this->request->except(['_token']);
        // dd($data);
		// 判断执行类型
		$id = $data['id'];
		$is_return = false;
		if($this->request->input('_method') == 'PUT'){
			$val = $data['val'] == 0 ? 1 : 0;
			$arr = ['state'=>$val];
			$is_return = true;
		}else{
			$arr['phone'] = $data['data']['phone'];
			$arr['remark'] = $data['data']['remark'];
		}

		$result = $this->model->wareUpdate($id,$arr);
		// 加入返回值
		if($is_return){
			$result['val'] = $val;
		}
		return $result;

	}

	public function del(){
		// dump($ware);
		$data = $this->request->except(['_token']);
		// 判断执行类型
		$id = $data['id'];
		
		$result = $this->model->wareDel($id);
   		return $result;
	}

	public function alltong(){

		$data = $this->request->except(['_token']);
		// 判断执行类型
		$id = $data['id'];
		
		$result = $this->model->waretong($id);

		return $result;

	}

	//查看详情
	public function info(Ware $ware){

		// dump($toload);

		$is_data = $this->request->input('data');
		//判断是否是调用数据
		if($is_data){
			$data = $this->request->input();
			$result = $ware->wareInfoindex($data);
			return $result;
		}

		return self::loadView();

	}

	public function infoadd(Ware $ware){

		return self::loadView();

	}

	public function infoinsert(Ware $ware){

		$data = $this->request->except(['_token']);
		$result = $ware->wareInfoinsert($data);
        return $result;

	}

	public function infodel(Ware $ware){

		$data = $this->request->except(['_token','_method']);
		$result = $ware->wareInfodel($data['id']);
        return $result;

	}

	public function infoupdate(Ware $ware){

		$data = $this->request->except(['_token']);
		// 判断执行类型
		$id = $data['id'];
		$is_return = false;
		if($this->request->input('_method') == 'PUT'){
			$val = $data['val'] == 0 ? 1 : 0;
			$arr = ['state'=>$val];
			$is_return = true;
		}else{
			$arr['order_number'] = $data['data']['order_number'];
			$arr['number'] = $data['data']['number'];
			$arr['remark'] = $data['data']['remark'];
		}

		$result = $ware->wareInfoupdate($id,$arr);
		// 加入返回值
		if($is_return){
			$result['val'] = $val;
		}
		return $result;

	}

	public function infoalldel(Ware $ware){

		$data = $this->request->except(['_token']);
		// 判断执行类型
		$id = $data['id'];
		
		$result = $ware->wareInfodel($id);

		return $result;

	}
	public function infoalltong(Ware $ware){

		$data = $this->request->except(['_token']);
		// 判断执行类型
		$id = $data['id'];
		
		$result = $ware->wareInfotong($id);

		return $result;

	}


	/*public function typeadd(){

		if($this->request->isMethod('post')){
			// 要执行的代码

			$data = $this->request->input();

			$result = (new WareOperation)->operIndex($data);

			return $result;
		}

		
		return self::loadView();
	}*/

	/*public function productadd(){


		if($this->request->isMethod('post')){
			// 要执行的代码

			$data = $this->request->input();

			$result = (new Product)->productIndex($data);

			return $result;
		}

		
		return self::loadView();
	}*/



}
