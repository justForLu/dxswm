<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class ManagerTypeEnum extends BaseEnum {

    const SYSTEM = 1;
    const BUSINESS = 2;

    static $desc = array(
        'SYSTEM' => '系统管理员',
        'BUSINESS' => '店家管理员',
    );

}
