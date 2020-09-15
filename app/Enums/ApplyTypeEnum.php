<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class ApplyTypeEnum extends BaseEnum {

    const RIDER = 2;
    const BUSINESS = 3;

    static $desc = array(
        'RIDER' => '骑手',
        'BUSINESS' => '开店',
    );

}
