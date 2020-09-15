<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class ApplyStatusEnum extends BaseEnum {

    const NOCHECK = 1;
    const CHECKING = 2;
    const CHECKED = 3;
    const REFUSED = 4;

    static $desc = array(
        'NOCHECK' => '待审核',
        'CHECKING' => '审核中',
        'CHECKED' => '审核通过',
        'REFUSED' => '审核拒绝',
    );

}
