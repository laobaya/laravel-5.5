<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\My\Path;


class CommonController extends Controller
{
 
    //视图主目录
    const ViewPath = 'admin';

    //视图路径
    protected $Path;

    //当前控制器视图
    protected $CM;

    //所有目录 
    protected $PathArr = [];

    //请求对象
    protected $request;

    //model对象
    protected $model;

	public function __construct(){


	}


	//进行加载的页面
    protected function PathInfo(){

    	$path = self::ViewPath;

    	if( ! empty($this->CM)){
    		$path .= '.'.$this->CM;
    	}
    	
    	if(array_key_exists($this->Path()->Path, $this->PathArr) && ! empty($this->PathArr[$this->Path])){
    		$path .= '.'.$this->PathArr[$this->Path];
    	}
    	
    	return $path;

    }


    //获取当前方法的路径
    protected function Path(){

    	$path = new Path();
		$this->Path = $path->getCurrentControllerMethod();

		return $this;
    }
    
    //加载视图
    protected function loadView($data=[]){


		return view(self::PathInfo(),$data);

    }

}
