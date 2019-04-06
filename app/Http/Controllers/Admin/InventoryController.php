<?php 

namespace App\Http\Controllers\Admin;

use App\Model\Inventory;
use Illuminate\Http\Request;

class InventoryController extends CommonController
{

	//加载配置项
	public function __construct(Request $request,Inventory $inventory){

		$this->request = $request;
		$this->CM = 'inventory';//声明控制器模板路径
		$this->PathArr = ['index'=>'index2','show'=>'show'];//声明访问文件
		$this->model = $inventory;
 
	}

	public function index(){

		
		$is_data = $this->request->input('data');
		$data = $this->request->input();

		//判断是否是调用数据
		if($is_data){

			$result = $this->model->inventoryIndex($data);
			return $result;
		}
		
		// dump($result);
		return self::loadView();

	}

	public function show($id){
		
		$is_data = $this->request->input('data');
		$data = $this->request->input();

		//判断是否是调用数据
		if($is_data){

			$result = $this->model->inventoryShow($id,$data);
			return $result;
		}
		
		// dump($result);
		return self::loadView();
	}


}