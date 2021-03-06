<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends BashModel
{
    //引入扩展
    use SoftDeletes;

    
    protected $table = 'menu';//设置表名
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
    ];//插入字段
    /*
    * 递归调用菜单数据
    */
    static protected function sortMenu($menus,$pid=0)
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

    // 加载首页
    public function menuIndex($data){

        $cate_name = isset($data['cate_name']) ? $data['cate_name'] : '' ;
        //判断是否是否传入
        if($cate_name){
            $this->firstOrCreate(['name'=>$cate_name]);
        }

        $menu = self::menuList();

        $toload = array(
            'menu'=>$menu
        );

        return $toload;
    }

    // 插入数据
    public function menuInsert($data){

        //继承父类的标识
        $data['level'] = $this['level']+1;
        $data['pid'] = $this['id'];
        
        $res = $this->insert($data);

        //判断是否成功插入
        if($res){
            $result = array('res'=>0,'msg'=>'添加成功');
        }else{
            $result = array('res'=>1,'msg'=>'添加失败');
        }

        return $result;

    }

    static public function menuList($where=[]){
        $menu = self::sortMenu(self::orderBy('order')->where($where)->get()->toArray());
        return $menu;
    }



    static public function menuEach($data,$user){

        $str = null;
        if(empty($data)){
            return '';
        }

        foreach ($data as $val) {
                
        // dump($val);
        if($user['id'] == 1 ||  (in_array($val['id'],$user['menu']) || $val['pid'] != 0)){



            $is_child = count($val['child']) ? true : false;
            if($is_child){
                $strheads = 'href="javascript:;"';
                $child = '<ul class="sub-menu">'.self::menuEach($val['child'],$user).'</ul>';
            }else{
                $strheads = "_href=".$val['href'];
                $child = '';
            }
            $ico = empty($val['ico']) ? '&#xe6a7;' : $val['ico'];

$menuHtml =<<<HTML
<li><a {$strheads}><i class="iconfont">{$ico}</i><cite>{$val['name']}</cite><i class="iconfont nav_right">&#xe697;</i></a>{$child}</li>
HTML;

$str .= $menuHtml;
            }
        
        }

        return $str;

        
    }

    //加载修改信息
    public function menuEdit(){

        $topmenu = $this->where('pid',0)->get();
        $toload = array(
                'menu'=>$this,
                'topmenu'=>$topmenu
        );

        return $toload;
    }

    public function menuUpdate($data){
        // dd($data);
        //判断是否发生改变
        $c = array_diff($data,$this->toArray());
        if(count($c) > 0){

            //判断是几级菜单
            $data['level'] = ($data['pid'] != 0) ? 1 : 0;

            $res = $this->where('id',$this['id'])->update($data);

            if($res){
                $result = array('res'=>0,'msg'=>'修改成功');
            }else{
                $result = array('res'=>1,'msg'=>'修改失败');
            }

        }else{
            $result = array('res'=>0,'msg'=>'页面关闭');
        }
        return $result;
    }
    // 删除
    public function menuDel(){

        if($this['pid'] == 0){
            $result = array('res'=>400,'msg'=>'权限不足');
        }else{
            $res = $this->destroy($this['id']);
            
            if($res){
                $result = array('res'=>0,'msg'=>'删除成功');
            }else{
                $result = array('res'=>1,'msg'=>'删除失败');
            }
        }
            
        return $result;
    }

    //修改
    public function menuState($arr){
        // dump($arr);
        $res = $this->where('id',$this['id'])->update($arr);
        // dump($res);
        if($res){
            $result = array('res'=>0,'msg'=>'切换成功');
        }else{
            $result = array('res'=>1,'msg'=>'切换失败');
        }

        return $result;
    }

}
