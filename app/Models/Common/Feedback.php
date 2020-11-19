<?php

namespace App\Models\Common;

use App\Models\Base;

class Feedback extends Base
{
    // 反馈
    protected $table = 'feedback';

    protected $fillable = ['id','name','mobile','email','content','status','remark','admin_id'];


}
