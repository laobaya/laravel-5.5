<?php

namespace App\Http\Controllers\Admin;

use App\Model\WareOperation;
use Illuminate\Http\Request;

class OperationController extends CommonController
{


	//加载配置项
	public function __construct(Request $request,WareOperation $operation){

		$this->request = $request;
		$this->CM = 'operation';//声明控制器模板路径
		$this->PathArr = ['index'=>'index','typeadd'=>'add'];//声明访问文件
		$this->model = $operation;
	}


	public function index(){

		$is_data = $this->request->input('data');
		//判断是否是调用数据
		if($is_data){
			$data = $this->request->input();
			$result = $this->model->OperIndex($data);
			return $result;
		}
		
		// dump($result);
		return self::loadView();
	}


	public function typeadd(){


		if($this->request->isMethod('post')){
			// 要执行的代码

			$data = $this->request->input();

			$result = $this->model->OperCreate($data);

			return $result;
		}

		
		return self::loadView();
	}

	public function update(){

		$data = $this->request->input();
		// dump($data);
		$id = $data['id'];

		$is_return = false;
		if($this->request->input('_method') == 'PUT'){

			$val = $data['val']  == '+' ? '-' : '+' ;
			$updateDate = ['operation'=>$val];
			$is_return = true;
		}else{
			$updateDate = ['name'=>$data['data']['name']];
		}
		
		// $updateDate = ['name'=>$data['data']['name'],'operation'=>$data['data']['operation']];
		$result = $this->model->OperUpdate($id,$updateDate);

		// 加入返回值
		if($is_return){
			$result['val'] = $val;
		}

		return $result;
	}


	public function del(){

		$data = $this->request->except(['_token']);
		// 判断执行类型
		$id = $data['id'];
		
		$result = $this->model->OperDel($id);
   		return $result;
	}

}
