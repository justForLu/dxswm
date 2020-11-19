<?php

namespace App\Models\Common;

use App\Models\Base;

class Evaluate extends Base
{
    // 评价
    protected $table = 'evaluate';

    protected $fillable = ['id','goods_id','user_id','image','content','score','type','is_anonymous'];



}
