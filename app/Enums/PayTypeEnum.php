<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class PayTypeEnum extends BaseEnum {

    const WEIXIN = 1;
    const ALIPAY = 2;

    static $desc = array(
        'WEIXIN' => '微信支付',
        'ALIPAY' => '支付宝支付',
    );

}
