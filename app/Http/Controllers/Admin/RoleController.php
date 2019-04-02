<?php

namespace App\Http\Controllers\Admin;

use App\Model\Role;
use App\Model\Rule;
use Illuminate\Http\Request;

class RoleController extends CommonController
{


	//加载配置项
	public function __construct(Request $request,Role $role){

		$this->request = $request;
		$this->CM = 'role';//声明控制器模板路径
		$this->PathArr = ['index'=>'index','add'=>'add','edit'=>'edit','rule'=>'rule','ruleadd'=>'ruleadd','ruleedit'=>'ruleedit'];//声明访问文件
		$this->model = $role;//加载model类

	}


  public function index(){

      $toload = $this->model->index();
      // dump($toload);
      return self::loadView($toload);
  }


  public function add(){

    $toload = $this->model->roleadd();
    // dump($toload);
    return self::loadView($toload);
  }

  public function insert(){

    $data = $this->request->except(['_token']);
    $result = $this->model->roleInsert($data);
    return $result;
  }

  public function edit(Role $role){
    $toload =  $role->roleEdit();
    // dump($toload);
    return self::loadView($toload);
  }

  public function update(Role $role){

    $data = $this->request->except(['_token']);
    $result = $role->roleUpdate($data);
    return $result;
  }

  public function state(){

    $data = $this->request->except(['_token']);
    $result = $this->model->roleState($data);
    
    return $result;
  }





  public function rule(){

    $toload = $this->model->rule()->index();
    // dump($toload);
    
    return self::loadView($toload);

  }

  public function ruleadd(){

    $toload = $this->model->rule()->ruleAdd();

    return self::loadView($toload);

  }
  public function ruleinsert(){

    $data = $this->request->except(['_token']);
    $result = $this->model->rule()->ruleInsert($data);
    
    return $result;
  }

  public function ruleedit(Rule $rule){

    $toload = $rule->ruleEdit();
    return self::loadView($toload);

  }

  public function ruleupdate(Rule $rule){

    $data = $this->request->except(['_token','_method']);
    $result = $rule->ruleUpdate($data);
    
    return $result;

  }

  public function ruledel(Rule $rule){

    $result = $rule->ruleDel();
    return $result;
  }
}
