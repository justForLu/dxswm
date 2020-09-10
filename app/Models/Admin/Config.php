<?php

namespace App\Models\Admin;

use App\Models\Base;

class Config extends Base
{
    // 模型对应表名
    protected $table = 'config';

    protected $fillable = ['title','copyright'];

    public $timestamps = false;

}
