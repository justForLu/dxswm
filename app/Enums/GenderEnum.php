<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class GenderEnum extends BaseEnum {

    const MAN = 1;
    const WOMAN = 2;

    static $desc = array(
        'MAN' => '男',
        'WOMAN' => '女',
    );

}
