<?php

namespace App\Enums;

/**
 * @method static BaseEnum ENUM()
 */
class CategoryEnum extends BaseEnum {

    const FOOD = 1;
    const FRUITS = 2;
    const GIFT = 3;

    static $desc = array(
        'FOOD' => '美食',
        'FRUITS' => '水果',
        'GIFT' => '礼物',
    );

}
