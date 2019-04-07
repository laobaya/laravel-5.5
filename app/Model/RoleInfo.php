<?php

namespace App\Model;


class RoleInfo extends BashModel
{
    
    protected $table = 'role_access';//设置表名
    protected $fillable = [
        'role_id',
        'rule_id'
    ];//插入字段
    public $timestamps = false;



    
}
