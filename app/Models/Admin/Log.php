<?php

namespace App\Models\Admin;

use App\Models\Base;

class Log extends Base
{
    // 模型对应表名
    protected $table = 'log';

    protected $fillable = ['id','user_id','operate_module','operate_action','operate_url','ip','content','module'];

    public $timestamps = false;

    /**
     * 日志操作人
     */
    public function manager(){
        return $this->hasOne(Manager::class,'id','user_id');
    }
}
