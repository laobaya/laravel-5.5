<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class WareInfo extends Model
{
    
    
    protected $table = 'ware_info';//设置表名
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at'];

 	

}
