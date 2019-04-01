<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RoleInfo extends Model
{
    
    protected $table = 'role_access';//设置表名
    protected $fillable = [
        'role_id',
        'rule_id'
    ];//插入字段
    public $timestamps = false;

}
