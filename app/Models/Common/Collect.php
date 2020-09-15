<?php

namespace App\Models\Common;

use App\Models\Base;

class Collect extends Base
{
    // 收藏
    protected $table = 'collect';

    protected $fillable = ['id','user_id','goods_id'];



}
