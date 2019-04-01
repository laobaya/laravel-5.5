<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    
    protected $table = 'role';//设置表名
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name','account','menu'
    ];//插入字段

    public function index(){
        $role = $this->get();
        $toload = array(
            'role'=>$role
        );
        return $toload;
    } 


    public function roleadd(){

        $role = $this->get();
        $rule = Rule::get();
        $menu = menu::where('pid',0)->get();
        $toload = array(
            'role'=>$role,
            'rule_class'=>$rule,
            'menu'=>$menu,
        );
        return $toload;
    }


    public function roleInsert($data){

        // dd($data);
        $objId = $this->create($data);
        
        foreach ($data['rule'] as $k => $val) {
            $rule[$k]['rule_id'] = $val;
        }
        /*dump($rule);
        dd();*/
        $res = $objId->roleInfo()->createMany($rule);

        dump($res);

    }

    public function roleState($data){

       
        $res = $this->where('id',$data['id'])->update(['state'=>$data['state']]);
        if($res){
            $result = array('res'=>0,'msg'=>'更新成功');
        }else{
            $result = array('res'=>1,'msg'=>'更新失败');
        }
        return $result;
    }


    public function rule(){

        return new Rule;

    }

    public function roleInfo(){

        return $this->hasMany('App\Model\RoleInfo');

    }

    // 修改菜单
    public function setMenuAttribute($value){

        $val = is_string($value) ? $value : (is_array($value) ? implode(",",$value) : '');
        // dd($val);
        $this->attributes['menu'] = $val;

    }

}
