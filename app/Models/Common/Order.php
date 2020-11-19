<?php

namespace App\Models\Common;

use App\Models\Base;

class Order extends Base
{
    // 订单
    protected $table = 'order';

    protected $fillable = ['id','business_id','order_code','user_id','rider_id','order_money','discount_money','pay_money',
        'pay_type','mobile','province','city','area','school_id','address','user_name','number','order_time','pay_time','cancel_time',
        'status','evaluate_status','transaction_id','remark'];



}
