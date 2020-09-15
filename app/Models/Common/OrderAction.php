<?php

namespace App\Models\Common;

use App\Models\Base;

class OrderAction extends Base
{
    // 订单操作
    protected $table = 'order_action';

    protected $fillable = ['id','order_id','user_id','order_status','action_place','action_type','action_note'];



}
