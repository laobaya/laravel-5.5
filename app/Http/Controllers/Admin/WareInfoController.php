<?php

namespace App\Http\Controllers\Admin;

use App\Model\WareInfo;
use Illuminate\Http\Request;

class WareInfoController extends CommonController
{


	//加载配置项
	public function __construct(Request $request,WareInfo $wareInfo){

		$this->request = $request;
		$this->CM = 'ware';//声明控制器模板路径
		$this->PathArr = ['index'=>'info'];//声明访问文件
		$this->model = $wareInfo;//加载model类

	}


	public function index(){

		$is_data = $this->request->input('data');
		//判断是否是调用数据
		if($is_data){

			$data = $this->request->input();
			$result = $this->model->wareInfoindex($data);
			return $result;
		}

		return self::loadView();

	}

	public function add(){
		return '请在详情添加';
	}

	public function update(){

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

		$result = $this->model->wareInfoupdate($id,$arr);
		// 加入返回值
		if($is_return){
			$result['val'] = $val;
		}
		return $result;

	}



	public function infodel(){

		$data = $this->request->except(['_token','_method']);
		$result = $this->model->wareInfodel($data['id']);
        return $result;

	}

	public function infoalldel(){

		$data = $this->request->except(['_token']);
		// 判断执行类型
		$id = $data['id'];
		
		$result = $this->model->wareInfodel($id);

		return $result;

	}
	public function infoalltong(){

		$data = $this->request->except(['_token']);
		// 判断执行类型
		$id = $data['id'];
		
		$result = $this->model->wareInfotong($id);

		return $result;

	}
}
