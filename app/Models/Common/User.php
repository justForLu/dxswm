<?php

namespace App\Models\Common;

use App\Models\Base;

class User extends Base
{
    // 用户
    protected $table = 'user';

    protected $fillable = ['id','openid','nickname','avatar','gender','mobile','login_time','login_ip','is_business','is_rider',
        'status'];



}
