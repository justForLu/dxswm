<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class BoolEnum extends BaseEnum {

    const YES = 1;
    const NO = 0;

    static $desc = array(
        'YES'=>'是',
        'NO'=>'否',
    );

}
