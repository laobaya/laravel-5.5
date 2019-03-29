<?php 

namespace App\Http\Controllers\Admin;

use App\model\Inventory;
use Illuminate\Http\Request;

class InventoryController extends CommonController
{

	//加载配置项
	public function __construct(Request $request,Inventory $inventory){

		$this->request = $request;
		$this->CM = 'inventory';//声明控制器模板路径
		$this->PathArr = ['index'=>'index1'];//声明访问文件
		$this->model = $inventory;
 
	}

	public function index(){


		/*$is_data = $this->request->input('data');
		//判断是否是调用数据
		if($is_data){

			$data = $this->request->input();
			$result = $this->model->index($data);
			return $result;
		}*/
		$data = $this->request->input();

		$result = $this->model->index($data);

		// dump($result);
		return self::loadView($result);

	}




}