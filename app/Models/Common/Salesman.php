<?php

namespace App\Models\Common;

use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salesman extends Base
{

    use SoftDeletes;

    // 业务员
    protected $table = 'salesman';

    protected $fillable = ['id','name','mobile','weixin','status'];

}
