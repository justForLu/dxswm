<?php

namespace App\Models;

use App\Enums\BasicEnum;

class Accounts extends Base
{
    // 模型对应表名
    protected $table = 'accounts';

    protected $fillable = ['name','original_id','app_id','app_secret','mch_id','pay_secret','token','aes_key','wechat_account',
        'hotel_model','tag','access_token','jsapi_ticket','account_type','status','create_time','update_time'];

    protected $attributes = array(
        'status' => BasicEnum::ACTIVE
    );

}
