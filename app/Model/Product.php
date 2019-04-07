<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BashModel
{
    use SoftDeletes;
    
    protected $table = 'product';//设置表名
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at'];
     protected $fillable = [
        'name',
    ];//插入字段
    public function productIndex($data){

    	$res = $this->create($data);

    	if($res){
            $result = array('res'=>0,'msg'=>'创建成功');
        }else{
            $result = array('res'=>1,'msg'=>'创建失败');
        }
        return $result;
    }

    public function productIndex(){


        return 1;

    }

    

}
