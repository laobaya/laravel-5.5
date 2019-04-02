<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;

class UserController extends CommonController
{
    
    //加载配置项
	public function __construct(Request $request,User $user){

		$this->request = $request;
		$this->CM = 'user';//声明控制器模板路径
		$this->PathArr = ['index'=>'index','edit'=>'edit'];//声明访问文件
		$this->model = $user;//加载model类

	}

	public function index(){

	    $toload = $this->model->index();
		return self::loadView($toload);
	}

	public function edit(User $user){

	    $toload = $user->userEdit();
		return self::loadView($toload);

	}
}
