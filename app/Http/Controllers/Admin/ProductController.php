<?php

namespace App\Http\Controllers\Admin;

use App\Model\Product;
use Illuminate\Http\Request;

class ProductController extends CommonController
{


	//加载配置项
	public function __construct(Request $request,Product $product){

		$this->request = $request;
		$this->CM = 'product';//声明控制器模板路径
		$this->PathArr = ['index'=>'index','productadd'=>'add'];//声明访问文件
		$this->model = $product;
	}


	public function index(){

		$is_data = $this->request->input('data');
		//判断是否是调用数据
		if($is_data){
			$data = $this->request->input();
			$result = $this->model->productIndex($data);
			return $result;
		}
		
		// dump($result);
		return self::loadView();
	}


	public function productadd(){


		if($this->request->isMethod('post')){
			// 要执行的代码

			$data = $this->request->input();

			$result = $this->model->productCreate($data);

			return $result;
		}

		
		return self::loadView();
	}

	public function update(){

		$data = $this->request->input();
		// dump($data);
		$id = $data['id'];
		$updateDate = ['name'=>$data['data']['name']];
		$result = $this->model->productUpdate($id,$updateDate);
		return $result;
	}


	public function del(){

		$data = $this->request->except(['_token']);
		// 判断执行类型
		$id = $data['id'];
		
		$result = $this->model->productDel($id);
   		return $result;
	}

}
