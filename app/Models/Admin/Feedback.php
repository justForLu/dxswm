<?php

namespace App\Models\Admin;

use App\Models\Base;

class Feedback extends Base
{
    // 模型对应表名
    protected $table = 'feedback';

    protected $fillable = ['name','mobile','email','content','status','remark','admin_id'];


}
