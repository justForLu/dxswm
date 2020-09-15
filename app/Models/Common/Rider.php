<?php

namespace App\Models\Common;

use App\Models\Base;

class Rider extends Base
{
    // 骑手
    protected $table = 'rider';

    protected $fillable = ['id','user_id'];



}
