<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class BiddingController extends CommonController
{


	//加载配置项
	public function __construct(Request $request){

		$this->request = $request;
		$this->CM = 'bidding';//声明控制器模板路径
		$this->PathArr = ['rushindex'=>'r_index'];//声明访问文件
		$this->model = $role;//加载model类

	}


  public function rushIndex(){

      $toload = $this->model->index();
      // dump($toload);
      return self::loadView($toload);
  }

}
