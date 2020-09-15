<?php

namespace App\Models\Common;

use App\Models\Base;

class Category extends Base
{
    // 模型对应表名
    protected $table = 'category';

    protected $fillable = ['id','business_id','name','pid','type','sort','status','image'];



}
