<?php

namespace App\Models\Common;

use App\Models\Base;

class OrderGoods extends Base
{
    // 订单商品
    protected $table = 'order_goods';

    protected $fillable = ['id','order_id','goods_id','goods_name','old_price','price'];



}
