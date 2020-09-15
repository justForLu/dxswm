<?php

namespace App\Models\Common;

use App\Models\Admin\Manager;
use App\Models\Base;

class Apply extends Base
{
    // 申请表
    protected $table = 'apply';

    protected $fillable = ['id','user_id','type','status','refuse','admin_id','remark','salesman_id'];

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
