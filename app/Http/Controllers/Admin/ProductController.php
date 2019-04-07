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
		$this->PathArr = ['index'=>'index'];//声明访问文件
		$this->model = $product;
	}


	public function index(){

		$is_data = $this->request->input('data');
		//判断是否是调用数据
		if($is_data){

			$result = $this->model->productIndex();
			return $result;
		}
		
		// dump($result);
		return self::loadView();
	}


}
