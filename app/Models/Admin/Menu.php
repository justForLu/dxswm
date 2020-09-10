<?php

namespace App\Models\Admin;


use App\Enums\BasicEnum;
use App\Enums\BoolEnum;
use App\Enums\ModuleEnum;
use App\Models\Base;

class Menu extends Base
{
    // 模型对应表名
    protected $table = 'menu';

    protected $fillable = ['name','code','parent','path','url','grade','sort','status','module','is_system'];

    public $timestamps = false;

    protected $attributes = array(
        'status' => BasicEnum::ACTIVE,
        'module' => ModuleEnum::ADMIN,
        'is_system' => BoolEnum::NO
    );

    /**
     * 获取菜单下的权限
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions(){
        return $this->hasMany(Permission::class,'menu_id','id')->where('is_system',BoolEnum::NO);
    }
}
