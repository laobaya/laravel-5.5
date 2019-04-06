<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ware extends Model
{
    use SoftDeletes;
    
    public $timestamps = true;
    protected $table = 'warehouse';//设置表名
    protected $primaryKey = 'id'; //主键
    protected $fillable = [
        'name',
        'phone',
        'u_id',
        'ua_id',
        'remark',
        'type'
    ];//插入字段
    protected $hidden = [
        'deleted_at',
        'u_id',
        'ua_id'

    ];//隐藏指定字段
    protected $appends = [
        'operation'
    ];//查询压入字段
    protected $dates = ['deleted_at'];//软删除

    //首页
    public function wareIndex($data){
        
        //获取上个月一号到现在的

        $start = isset($data['where']['start']) ? $data['where']['start'] : date('Y-m-01',strtotime(date('Y').'-'.(date('m')-1).'-01'));
        // $start = isset($data['where']['start']) ? $data['where']['start'] : date('Y-m-01');
        $end = isset($data['where']['end']) ? $data['where']['end'] : date('Y-m-t');
        $type = NULL;
        $phone = NULL;
        if(isset($data['where'])){
            $type = (!is_null($data['where']['type'])) ? $data['where']['type'] : '';
            $phone = isset($data['where']['phone']) ? $data['where']['phone'] : '';
        }
        
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $ware = $this->setappends(['user','type_name'])
        ->orderBy('created_at','DESC')
        ->whereDate('created_at','>=',$start)
        ->whereDate('created_at','<=',$end)
        ->when($type != null,function($query) use ($type){
             $query->where('type',$type);
        })
        ->when($phone,function($query) use ($phone){
             $query->where('phone',$phone);
        })
        ->paginate($limit)->toArray();
        // dump($ware);
        if(!empty($ware)){

            $result = ['code'=>0,'msg'=>'获取成功','data'=>$ware['data'],'count'=>$ware['total']];
            
        }else{

            $result = ['code'=>1,'msg'=>'获取失败'];

        }
        // dd($result['data'][0]->product);
        return $result;

        /*$ware = $this->paginate(10);
        $toload = array(
            'ware'=>$ware
        );
        return $toload;*/
    }    

    //插入数据
    public function wareInsert($data){

        $data['u_id'] = \Auth::id();
        $res = $this->create($data);

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

    public function wareUpdate($id,$data=[]){

        // dump($data);
        $data['ua_id'] = \Auth::id();

        $res = $this->where('id',$id)->update($data);
        if($res){
            $result = array('res'=>0,'msg'=>'更新成功');
        }else{
            $result = array('res'=>1,'msg'=>'更新失败');
        }
        return $result;
    }

    public function wareDel($id){

        // dd($this['id']);
        $id = is_array($id) ? $id : ( is_string($id) ?explode (',',$id) :func_get_args());

        $res = $this->whereIn('id',$id)->delete();
        
        if($res){
            $this->wareInfo()->whereIn('ware_id',$id)->delete();
            $result = array('res'=>0,'msg'=>'删除成功');
        }else{
            $result = array('res'=>1,'msg'=>'删除失败');
        }
        return $result;
        
    }

    public function wareInfoindex($data){

        

        /*$start = isset($data['where']['start']) ? $data['where']['start'] : date('Y-m-01',strtotime(date('Y').'-'.(date('m')-1).'-01'));
        $end = isset($data['where']['end']) ? $data['where']['end'] : date('Y-m-t');*/

        $start = isset($data['where']['start']) ? $data['where']['start'] : '';
        $end = isset($data['where']['end']) ? $data['where']['end'] : '';

        //获取需要查询的分类默认全查询
        $product = isset($data['where']['product_id']) ? $data['where']['product_id'] : '';

        // 获取查询的条数
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        
        $ware = $this->wareInfo()
        ->orderBy('created_at','DESC')
        ->when($product,function($query) use ($product){

             $query->where('product_id',$product);

        })->when($start,function($query) use ($start){

            $query->whereDate('created_at','>=',$start);

        })->when($end,function($query) use ($end){

            $query->whereDate('created_at','<=',$end);

        })
        ->paginate($limit)->toArray();
        
        if(!empty($ware)){

            $result = ['code'=>0,'msg'=>'获取成功','data'=>$ware['data'],'count'=>$ware['total']];
            
        }else{

            $result = ['code'=>1,'msg'=>'获取失败'];

        }
        // dd($result['data'][0]->product);
        return $result;
        

    }

    public function wareInfoinsert($data){
        
        // dump($data);
        $data['ware_id']= $this['id'];

        $res = $this->wareInfo()->create($data);
        if($res){
            $result = array('res'=>0,'msg'=>'创建成功');
        }else{
            $result = array('res'=>1,'msg'=>'创建失败');
        }
        return $result;

    }

    public function wareInfodel($id){

        $id = is_array($id) ? $id : ( is_string($id) ?explode (',',$id) :func_get_args());

        $res = $this->wareInfo()->whereIn('id',$id)->delete();
        
        if($res){
            $result = array('res'=>0,'msg'=>'删除成功');
        }else{
            $result = array('res'=>1,'msg'=>'删除失败');
        }
        return $result;
    }

    public function waretong($id){
        $id = is_array($id) ? $id : ( is_string($id) ?explode (',',$id) :func_get_args());

        $res = $this->whereIn('id',$id)->update(['state'=>0]);
        
        if($res){
            $result = array('res'=>0,'msg'=>'执行成功');
        }else{
            $result = array('res'=>1,'msg'=>'执行失败');
        }
        return $result;
    }

    public function wareInfotong($id){
        $id = is_array($id) ? $id : ( is_string($id) ?explode (',',$id) :func_get_args());

        $res = $this->wareInfo()->whereIn('id',$id)->update(['state'=>0]);
        
        if($res){
            $result = array('res'=>0,'msg'=>'执行成功');
        }else{
            $result = array('res'=>1,'msg'=>'执行失败');
        }
        return $result;
    }
    //改版1.0
    /*public function wareInfolist($data){

        // 获取查询的条数
        $limit = isset($data['limit']) ? $data['limit'] : 10;
        $ware = Ware::has('wareInfo')->paginate($limit)->toArray();

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

    }*/
    //改版1.0

    public function wareInfoupdate($id,$data=[]){

        $res = $this->wareInfo()->where('id',$id)->update($data);
        if($res){
            $result = array('res'=>0,'msg'=>'更新成功');
        }else{
            $result = array('res'=>1,'msg'=>'更新失败');
        }
        return $result;
    }

    //绑定对应的订单详情
    public function wareInfo()
    {
        return $this->hasMany('App\Model\WareInfo');
    }

    // 获取类型
    public function getTypeNameAttribute()
    {   
        $key = 'typeName_'.$this['type'];
        $value = session($key, null);
        if(is_null($value) || (time() - $value['time'] > 120)){
           $name = $this->hasOne('App\Model\WareOperation','id','type')->first()['name']; 
           session([$key =>['value'=>$name,'time'=>time()]]);
           $value = session($key, null);
        }

        return $value['value'];
    }

    //获取运算符
    public function getOperationAttribute(){


        $key = 'Operation_'.$this['type'];
        $value = session($key, null);
        if(is_null($value) || (time() - $value['time'] > 120)){
           $name = $this->hasOne('App\Model\WareOperation','id','type')->first()['operation']; 
           session([$key =>['value'=>$name,'time'=>time()]]);
           $value = session($key, null);
        }

        return $value['value'];

    }

    // 获取创建用户
    public function getUserAttribute(){
        
        $key = 'User_'.$this['u_id'];
        $value = session($key, null);
        if(is_null($value) || (time() - $value['time'] > 120)){
           $name = $this->hasOne('App\User','id','u_id')->first()['name']; 
           session([$key =>['value'=>$name,'time'=>time()]]);
           $value = session($key, null);
        }

        return $value['value'];

    }

    public function WareInfoSum(){
        return WareInfo::groupBy('ware_id')->sum('number');
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


    /*public function kucun(){
       

        $dd = $this->groupBy('date')->get([\DB::raw('DATE(created_at) as date'),\DB::raw('id')]);
        // $dd = $this->where('state',0)->groupBy('type')->get(['id','type']);
        
        dump($dd);

        $ids = $data = array();
        foreach ($dd as $k => $value) {
           $ids[$k] = array_map('array_shift', $value);
           $data[$k] = self::wareInfos($ids[$k]);
        }
        
        // $ids = array_column($dd, 'id');
        // dump($ids);
        // dump($data);
    }

    public function wareInfos($ids){

        $ids = is_array($ids) ? $ids : ( is_string($ids) ?explode (',',$ids) :func_get_args());
        $data = WareInfo::where('state',0)->whereIn('ware_id',$ids)->sum('number');
        return $data;
    }*/

}
