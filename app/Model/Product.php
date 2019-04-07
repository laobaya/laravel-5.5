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


     /**
     * [getSellerQuData 获取商户结算数据 曲线]
     * @param  [string] $start [起始时间]2017-08
     * @param  [string] $end   [结束时间]
     * @return [type]        [description]
     */
    public function getSellerQuData($name,$start,$end){

        //计算时间差值,以决定格式化时间格式
        $diff = strtotime($end)-strtotime($start);

        //分组条件 1天内按小时分组,否则按天/月分组
        //86400/1天 2678400/1月
        if($diff<86400&&$diff>0){
            $sort = '%H';
        }elseif($diff<2678400){
            $sort = '%Y-%m-%d';
        }else{
            $sort = '%Y-%m';
        }
        //把数据添加时间按格式化时间分组求和,求和分两种,一种是直接求和,一种是满足case when条件的数据求和
        $query = DB::table('user_withdrawals as w')->select(DB::raw("FROM_UNIXTIME(created_at,'{$sort}') as thedata,sum(case when w.cash_type = 1 then w.money end) as xiabi,sum(case when w.cash_type = 2 then w.money end) as online,sum(w.money) as alls"))->groupBy(DB::raw("FROM_UNIXTIME(created_at,'{$sort}')"));

        //条件筛选 某时间段内
        if( !empty($start) ){
            $query->whereRaw('w.created_at >= ?',strtotime($start));
        }
        if( !empty($end) ){
            $query->whereRaw('w.created_at <= ?',strtotime($end));
        }

        $data = $query->get();

        return $data;
    }

}
