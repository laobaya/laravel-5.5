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
		$this->PathArr = ['index'=>'index','role'=>'edit'];//声明访问文件
		$this->model = $user;//加载model类

	}

	public function index(){

		$data = $this->request->except(['_token']);
	    $toload = $this->model->index($data);
		return self::loadView($toload);
	}

	public function edit(User $user){

		$data = $this->request->except(['_token']);
	    $result = $user->userEdit($data);
		return $result;

	}

	public function role(User $user){

		if($this->request->isMethod('post')){
			$data = $this->request->input();

			$result = $user->userRoleedit($data);

			return $result;
		}
		$toload = $this->model->userRole();
		// dump($toload);
		return self::loadView($toload);
	}

	public function del(User $user){
		$result = $user->userDel();
		return $result;
	}

	/*public function state(){

		$data = $this->request->except(['_token']);
	    $result = $this->model->userState($data);
		return $result;
	}*/


}
