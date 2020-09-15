<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class GoodsEnum extends BaseEnum {

    const ONSALE = 1;
    const OFFSALE = 2;

    static $desc = array(
        'ONSALE' => '上架',
        'OFFSALE' => '下架',
    );

}
