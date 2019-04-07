<?php

namespace App\Model;


class UserInfo extends BashModel
{
    
    protected $table = 'user_extend';//设置表名
    public $timestamps = false;
    protected $fillable = [
        'state'
    ];

}
