<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    
    protected $table = 'user_extend';//设置表名
    public $timestamps = false;
    protected $fillable = [
        'state'
    ];

}
