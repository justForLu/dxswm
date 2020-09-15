<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class OrderEnum extends BaseEnum {

    const UNPAID = 1;
    const PAID = 2;
    const CANCEL = 3;
    const NOEVALUATE = 4;
    const EVALUATE = 5;

    static $desc = array(
        'UNPAID' => '未支付',
        'PAID' => '已支付',
        'CANCEL' => '已取消',
        'NOEVALUATE' => '待评价',
        'EVALUATE' => '已评价',
    );

}
