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

	public function getProductAttribute()
	{

		$arr = ['','胶原蛋白','痔疮','蜂蜜'];
	    return $arr[$this['product_id']];
	}
}
