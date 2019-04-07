<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends BashModel
{
    use SoftDeletes;
    
    protected $table = 'rule';//设置表名
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'rule',
        'menu_id'
    ];//插入字段
    protected $appends = [
        'menu'
    ];//查询压入字段

    public function index(){
        $rules = $this->paginate(10);
        $toload = ['rules'=>$rules];
        return $toload;
    }
    
    public function ruleAdd(){

        $menu = Menu::where(['pid'=>0])->get(['id','name']);

        $toload = ['menu'=>$menu];
        return $toload;

    }


    public function ruleInsert($data){

        // dd($data);
        $res = $this->create($data);

        //判断是否成功插入
        if($res){
            $result = array('res'=>0,'msg'=>'添加成功');
        }else{
            $result = array('res'=>1,'msg'=>'添加失败');
        }

        return $result;

    }

    public function ruleEdit(){
        
        $menu = Menu::where(['pid'=>0])->get(['id','name']);

        $toload = [
            'menu'=>$menu,
            'rules'=>$this
        ];
        // dump($toload);
        return $toload;
    }


    public function ruleUpdate($data){
        
        // dd($data);
        $res = $this->where('id',$this['id'])->update($data);
        if($res){
            $result = array('res'=>0,'msg'=>'更新成功');
        }else{
            $result = array('res'=>1,'msg'=>'更新失败');
        }
        return $result;
        
    }


    public function ruleDel(){

        $res = $this->where('id',$this['id'])->delete();
        
        if($res){
            $result = array('res'=>0,'msg'=>'删除成功');
        }else{
            $result = array('res'=>1,'msg'=>'删除失败');
        }
        return $result;
    }


    // 获取菜单名
    public function getMenuAttribute()
    {

        $key = 'Menu_'.$this['menu_id'];
        $value = session($key, null);
        if(is_null($value) || (time() - $value['time'] > 120)){
           $name = $this->hasOne('App\Model\Menu','id','menu_id')->first()['name']; 
           session([$key =>['value'=>$name,'time'=>time()]]);
           $value = session($key, null);
        }

        return $value['value'];
    }
}
