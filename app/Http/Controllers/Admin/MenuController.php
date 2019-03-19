<?php

namespace App\Http\Controllers\Admin;

use App\Model\Menu;
use Illuminate\Http\Request;

class MenuController extends CommonController
{


	//加载配置项
	public function __construct(Request $request,Menu $menu){

		$this->request = $request;
		$this->CM = 'menu';//声明控制器模板路径
		$this->PathArr = ['index'=>'index'];//声明访问文件
		$this->model = $menu;

	}

	
	public function index(){


		$cate_name = $this->request->input('cate_name');
        
        //判断是否是否传入
        if($cate_name){
            
            $this->model->insert(['name'=>$cate_name]);

        }

        // $menu = $this->model->orderBy('order')->get();

        $menu = $this->model->sortMenu($this->model->orderBy('order')->get()->toArray());


        $toload = array(
            'menu'=>$menu
        );
        
        // dump($toload);

		return self::loadView($toload);

	}

	



}
