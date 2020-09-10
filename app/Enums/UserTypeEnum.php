<?php

namespace App\Enums;

/**
* @method static BaseEnum ENUM()
*/
class UserTypeEnum extends BaseEnum {

    const ADMIN = 1;
    const HOME = 2;

    static $desc = array(
        'ADMIN' => '后台',
        'HOME' => '前台',
    );
}
