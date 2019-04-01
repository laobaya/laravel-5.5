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
		$this->PathArr = ['index'=>'index','add'=>'add','edit'=>'edit'];//声明访问文件
		$this->model = $menu;//加载model类

	}

	// 加载首页
	public function index(){

		$data = $this->request->except(['_token']);
    $toload = $this->model->menuIndex($data);
        // dump($toload);
		return self::loadView($toload);

	}

	
	//加载添加目录
	public function add(Menu $menu){

		$toload = array(
                'menu'=>$menu,
                // 'topmenu'=>$topmenu
        );
		return self::loadView($toload);

	}

	// 插入
	public function insert(Menu $menu){


        $data = $this->request->except(['_token','_method']);
        $result = $menu->menuInsert($data);
        return $result;
        
    }


    // 修改信息
    public function edit(Menu $menu){

        $toload = $menu->menuEdit();
        return self::loadView($toload);
    }

   	public function update(Menu $menu){
   		// dd(1);
   		$data = $this->request->except(['_token','_method']);
   		$result = $menu->menuUpdate($data);
        return $result;

   	}

   	// 删除指定菜单
   	public function del(Menu $menu){

   		$result = $menu->menuDel();
   		return $result;
   	}

   	//切换状态
   	public function state(Menu $menu){
   		// dd(1);
   		$s = $this->request->input('state');
   		$state = $s ? 0 : 1;
   		$result = $menu->menuState(['state'=>$state]);
   		return $result;

   	}

   	public function order(Menu $menu){

   		$order = $this->request->input('order');
   		$result = $menu->menuState(['order'=>$order]);
   		return $result;

   	}
}
