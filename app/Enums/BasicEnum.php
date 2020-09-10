<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class BasicEnum extends BaseEnum {

    const ACTIVE = 1;
    const DISABLED = 2;

    static $desc = array(
        'ACTIVE' => '启用',
        'DISABLED' => '禁用',
    );

}
