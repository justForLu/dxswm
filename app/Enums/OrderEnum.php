<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class OrderEnum extends BaseEnum {

    const UNPAID        = 1;
    const PAID          = 2;
    const CANCEL        = 3;
    const NOEVALUATE    = 4;
    const EVALUATE      = 5;

    static $desc = array(
        'UNPAID'        => '待支付',
        'PAID'          => '已支付',
        'BCANCEL'       => '商家取消',
        'CCANCEL'       => '买家取消',
        'EVALUATE'      => '已完成',
    );

}
