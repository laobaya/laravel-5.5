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
        
        $ware = $this->paginate(1);
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

    public function wareUpdate($data){

        // dump($data);
        $res = $this->where('id',$this['id'])->update($data);
        if($res){
            $result = array('res'=>0,'msg'=>'修改成功');
        }else{
            $result = array('res'=>1,'msg'=>'修改失败');
        }
        return $result;
    }

    public function wareDel(){

        // dd($this['id']);
        $res = $this->destroy($this['id']);
            
        if($res){
            $result = array('res'=>0,'msg'=>'删除成功');
        }else{
            $result = array('res'=>1,'msg'=>'删除失败');
        }
        return $result;
        
    }

    public function wareInfos($data){

        $limit = isset($data['limit']) ? : 10;

        $ware = $this->wareInfo()->paginate($limit);
        // dump($ware);
        if(!empty($ware)){
            $result = array(
                'code'=>0,
                'msg'=>'获取成功',
                'data'=>$ware->items(),
                'count'=>$ware->total()
            );
        }else{
            $result = array('code'=>1,'msg'=>'获取失败');
        }
        return $result;

    }

    //绑定对应的订单详情
    public function wareInfo()
    {
        return $this->hasMany('App\Model\WareInfo');
    }


}
