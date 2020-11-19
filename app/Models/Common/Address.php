<?php

namespace App\Models\Common;

use App\Models\Admin\Manager;
use App\Models\Base;

class Address extends Base
{
    // 地址表
    protected $table = 'address';

    protected $fillable = ['id','user_id','name','mobile','school_id','address','longitude','latitude','is_default'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function salesman(){
        return $this->belongsTo(Salesman::class, 'salesman_id');
    }

    public function Manager(){
        return $this->belongsTo(Manager::class, 'admin_id');
    }

}
