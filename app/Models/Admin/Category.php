<?php

namespace App\Models\Admin;

use App\Models\Base;

class Category extends Base
{
    // 模型对应表名
    protected $table = 'category';

    protected $fillable = ['name','pid','type','sort','status','image'];



}
