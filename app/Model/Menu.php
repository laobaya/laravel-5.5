<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = 'menu';


    /*public function getNameAttribute($val){
        
        if($this->pid == 0){
            $result = str_repeat("&nbsp;",$this->level*4)."<i class='layui-icon x-show' status='true'>&#xe623;</i>".$val;
        }else{
            $result = str_repeat("&nbsp;",$this->level*4)."├".$val;
        }
        
        return $result;
    }*/



    /*
    * 递归调用菜单数据
    */
    public function sortMenu($menus,$pid=0)
    {
        $arr = [];
        if (empty($menus)) {
            return '';
        }

        foreach ($menus as $key => $value) {
            if ($value['pid'] == $pid) {
                $arr[$key] = $value;
                $arr[$key]['child'] = self::sortMenu($menus,$value['id']);
            }
        }
        return $arr;
    }
}
