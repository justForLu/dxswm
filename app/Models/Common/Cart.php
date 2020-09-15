<?php

namespace App\Models\Common;

use App\Models\Base;

class Cart extends Base
{
    // 购物车
    protected $table = 'cart';

    protected $fillable = ['id','user_id','business_id','goods_id','number'];



}
