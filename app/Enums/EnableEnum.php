<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class EnableEnum extends BaseEnum {

    const ENABLE = 1;
    const DISABLE = 2;

    static $desc = array(
        'ENABLE' => '启用',
        'DISABLE' => '禁用',
    );
}
