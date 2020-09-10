<?php

namespace App\Models\Admin;

use App\Enums\ModuleEnum;
use App\Models\Base;

class Permission extends Base
{
    // 模型对应表名
    protected $table = 'permission';

    protected $fillable = ['name','code','desc','menu_id','module','is_system'];

    public $timestamps = false;

    protected $attributes = array(
        'module' => ModuleEnum::ADMIN
    );

    public function menu(){
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
