<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class EvaluateStatusEnum extends BaseEnum {

    const NOEVALUATE = 0;
    const EVALUATE = 1;

    static $desc = array(
        'NOEVALUATE'    => '待评价',
        'EVALUATE'      => '已评价',
    );

}
