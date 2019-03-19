<?php 

namespace App\My;

use \Route;


class Path{

	/**
     * 验证用户权限
     * @author 晚黎
     * @date   2017-07-24T16:46:35+0800
     * @return [type]                   [description]
     */
    public function checkPermission()
    {
        $method = $this->getCurrentControllerMethod();
        // dump($method);
        $actionName = $this->getCurrentControllerName();
        // dump($actionName);
        $actionName = substr($actionName,0,-10);
        // dump($actionName);
        
        // dump($actionName);
        return strtolower($actionName.'.'.$method);
        // return haspermission(strtolower($actionName.'.'.$method));
    }
    /**
     * 获取当前控制器方法
     * @author 晚黎
     * @date   2017-07-24T14:23:52+0800
     * @return [type]                   [description]
     */
    public function getCurrentControllerMethod()  
    {  
        return $this->getCurrentActionAttribute()['method'];
    }
    /**
     * 获取当前控制器名称
     * @author 晚黎
     * @date   2017-07-24T14:24:04+0800
     * @return [type]                   [description]
     */
    public function getCurrentControllerName()  
    {  
        return $this->getCurrentActionAttribute()['controller'];
    }  
    /**
     * 获取当前控制器相关属性
     * @author 晚黎
     * @date   2017-07-24T14:24:14+0800
     * @return [type]                   [description]
     */
    private function getCurrentActionAttribute()  
    {  
        $action = Route::currentRouteAction();
        // dump($action);
        list($class, $method) = explode('@', $action);
        // dump($method);
        return ['controller' => class_basename($class), 'method' => $method];
    }


}
