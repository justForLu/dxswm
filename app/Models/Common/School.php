<?php

namespace App\Models\Common;

use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Base
{

    use SoftDeletes;

    // 高校
    protected $table = 'school';

    protected $fillable = ['id','name','province','city','area','status'];



}
