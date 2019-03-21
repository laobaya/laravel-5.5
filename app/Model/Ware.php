<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ware extends Model
{
    use SoftDeletes;
    
    
    protected $table = 'warehouse';//设置表名
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at'];


    //首页
    public function wareIndex($request){
        // dump($request->input());
        $ware = $this->paginate(10);
        $toload = array(
            'ware'=>$ware
        );
        return $toload;
    }    

    //插入数据
    public function wareInsert($data){

        $data['u_id'] = 1;
        $res = $this->insert($data);

        //判断是否成功插入
        if($res){
            $result = array('res'=>0,'msg'=>'添加成功');
        }else{
            $result = array('res'=>1,'msg'=>'添加失败');
        }

        return $result;
    }

    // 加载修改页面
    public function wareEdit(){

        $toload = array(
                'ware'=>$this,
        );

        return $toload;
    }

    public function wareDel(){
        
    }

    //绑定对应的订单详情
    public function wareInfo()
    {
        return $this->hasMany('App\Model\WareInfo');
    }


}
