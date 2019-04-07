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

    public function OperIndex($data){

    	$res = $this->create($data);

    	if($res){
            $result = array('res'=>0,'msg'=>'创建成功');
        }else{
            $result = array('res'=>1,'msg'=>'创建失败');
        }
        return $result;
    }

}
