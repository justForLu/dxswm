<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class CategoryEnum extends BaseEnum {

    const NEWS = 1;
    const PRODUCT = 2;

    static $desc = array(
        'NEWS' => '新闻',
        'PRODUCT' => '产品',
    );

}
