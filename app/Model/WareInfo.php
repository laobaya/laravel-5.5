<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WareInfo extends Model
{
    use SoftDeletes;
    
    public $timestamps = true;
    protected $table = 'ware_info';//设置表名
    protected $primaryKey = 'id'; //主键
    protected $dates = [
	    'deleted_at'
    ];//软删除
    protected $fillable = [
    	'ware_id',
    	'order_number',
    	'product_id',
    	'number'
    ];//插入字段
    protected $hidden = [
        'deleted_at',
    	'product_id',

    ];//隐藏指定字段
 	protected $appends = [
 		'product'
 	];//查询压入字段


    // 获取列表
    public function wareInfoindex($data){

        // 获取查询的条数
        // dump($data);
        
        $start = isset($data['where']['start']) ? $data['where']['start'] : date('Y-m-01');
        $end = isset($data['where']['end']) ? $data['where']['end'] : date('Y-m-t');

        /*$start = isset($data['where']['start']) ? $data['where']['start'] : date('Y-m-d');
        $end = isset($data['where']['end']) ? $data['where']['end'] : date('Y-m-d');*/
        $product = isset($data['where']['product_id']) ? $data['where']['product_id'] : '';
        

        $limit = isset($data['limit']) ? $data['limit'] : 10;
        
        $ware = $this->orderBy('created_at','DESC')->when($product,function($query) use ($product){
            
             $query->where('product_id',$product);
        })->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)
        ->paginate($limit)->toArray();
        
        if(!empty($ware)){

            $result = ['code'=>0,'msg'=>'获取成功','data'=>$ware['data'],'count'=>$ware['total']];
            
        }else{

            $result = ['code'=>1,'msg'=>'获取失败'];

        }
        // dd($result['data'][0]->product);
        return $result;

    }

    public function wareInfoupdate($id,$data=[]){

        $res = $this->where('id',$id)->update($data);
        if($res){
            $result = array('res'=>0,'msg'=>'更新成功');
        }else{
            $result = array('res'=>1,'msg'=>'更新失败');
        }
        return $result;
    }

    public function wareInfodel($id){

        $id = is_array($id) ? $id : ( is_string($id) ?explode (',',$id) :func_get_args());

        $res = $this->whereIn('id',$id)->delete();
        
        if($res){
            $result = array('res'=>0,'msg'=>'删除成功');
        }else{
            $result = array('res'=>1,'msg'=>'删除失败');
        }
        return $result;
    }

    public function wareInfotong($id){

        $id = is_array($id) ? $id : ( is_string($id) ?explode (',',$id) :func_get_args());

        $res = $this->whereIn('id',$id)->update(['state'=>0]);
        
        if($res){
            $result = array('res'=>0,'msg'=>'执行成功');
        }else{
            $result = array('res'=>1,'msg'=>'执行失败');
        }
        return $result;
    }

    // 获取产品名
	public function getProductAttribute()
	{
        return $this->hasOne('App\Model\Product','id','product_id')->first()['name'];
	}



    /*public function when($value, $callback, $default = null)
    {
        if ($value) {
            return $callback($this, $value) ?: $this;
        } elseif ($default) {
            return $default($this, $value) ?: $this;
        }

        return $this;
    }*/
}
