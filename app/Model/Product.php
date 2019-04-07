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
    public function productCreate($data){

    	$res = $this->create($data);

    	if($res){
            $result = array('res'=>0,'msg'=>'创建成功');
        }else{
            $result = array('res'=>1,'msg'=>'创建失败');
        }
        return $result;
    }

    public function productIndex($data){
        
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $product = $this->orderBy('created_at','DESC')
        ->paginate($limit)->toArray();
        // dump($ware);
        if(!empty($product)){

            $result = ['code'=>0,'msg'=>'获取成功','data'=>$product['data'],'count'=>$product['total']];
            
        }else{

            $result = ['code'=>1,'msg'=>'获取失败'];

        }
        // dd($result['data'][0]->product);
        return $result;

        
    }

    public function productUpdate($id,$data){

        $res = $this->where('id',$id)->update($data);
        if($res){
            $result = array('res'=>0,'msg'=>'更新成功');
        }else{
            $result = array('res'=>1,'msg'=>'更新失败');
        }
        return $result;
    }


    public function productDel($id){

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
