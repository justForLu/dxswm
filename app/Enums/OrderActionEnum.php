<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class OrderActionEnum extends BaseEnum {

    const SUBMIT    = 1;
    const PAID      = 2;
    const BRECEIVE  = 3;
    const BCANCEL   = 4;
    const CCANCEL   = 5;
    const RRECEIVE  = 6;
    const SEND      = 7;
    const DONE      = 8;
    const EVALUATE  = 9;
    const APPEAL    = 10;
    const APPEALED  = 11;

    static $desc = array(
        'SUBMIT'        => '订单提交',
        'PAID'          => '订单付款',
        'BRECEIVE'      => '商家接单',
        'BCANCEL'       => '商家取消',
        'CCANCEL'       => '买家取消',
        'RRECEIVE'      => '骑手接单',
        'SEND'          => '骑手送达',
        'DONE'          => '订单完成',
        'EVALUATE'      => '订单评价',
        'APPEAL'        => '订单申诉',
        'APPEALED'      => '申诉完成',
    );
}
