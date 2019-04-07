<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class WareOperation extends BashModel
{
    use SoftDeletes;
    
    protected $table = 'ware_operation';//设置表名
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'operation'
    ];//插入字段


    public function OperCreate($data){

        $res = $this->create($data);

        if($res){
            $result = array('res'=>0,'msg'=>'创建成功');
        }else{
            $result = array('res'=>1,'msg'=>'创建失败');
        }
        return $result;
    }

    public function OperIndex($data){
        
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $operation = $this->orderBy('created_at','DESC')
        ->paginate($limit)->toArray();
        // dump($ware);
        if(!empty($operation)){

            $result = ['code'=>0,'msg'=>'获取成功','data'=>$operation['data'],'count'=>$operation['total']];
            
        }else{

            $result = ['code'=>1,'msg'=>'获取失败'];

        }
        // dd($result['data'][0]->operation);
        return $result;

        
    }

    public function OperUpdate($id,$data){

        $res = $this->where('id',$id)->update($data);
        if($res){
            $result = array('res'=>0,'msg'=>'更新成功');
        }else{
            $result = array('res'=>1,'msg'=>'更新失败');
        }
        return $result;
    }


    public function OperDel($id){

        $id = is_array($id) ? $id : ( is_string($id) ?explode (',',$id) :func_get_args());

        $res = $this->whereIn('id',$id)->delete();
        
        if($res){
            $result = array('res'=>0,'msg'=>'删除成功');
        }else{
            $result = array('res'=>1,'msg'=>'删除失败');
        }
        return $result;
    }

}
