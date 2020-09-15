<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class BusinessEnum extends BaseEnum {

    const OPEN = 1;
    const CLOSE = 2;

    static $desc = array(
        'OPEN' => '在营业',
        'CLOSE' => '已打烊',
    );

}
