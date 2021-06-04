<?php

namespace App\Enums;

/**
* @method static BaseEnum ENUM()
*/
class UserEnum extends BaseEnum {

    const ACTIVE = 1;
    const DISABLED = 2;

    static $desc = array(
        'ACTIVE' => '正常',
        'DISABLED' => '禁用',
    );
}
