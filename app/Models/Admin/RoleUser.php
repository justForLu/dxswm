<?php

namespace App\Models\Admin;

use App\Models\Base;

class RoleUser extends Base
{
    // 模型对应表名
    protected $table = 'role_user';

    public $timestamps = false;

    protected $fillable = ['user_id','role_id','module'];
}
