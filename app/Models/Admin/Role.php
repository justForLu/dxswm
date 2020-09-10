<?php

namespace App\Models\Admin;


use App\Enums\BoolEnum;
use App\Enums\ModuleEnum;
use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Base
{
    // 模型对应表名
    protected $table = 'role';

    protected $fillable = ['parent','name','desc','module','is_system'];

    protected $attributes = array(
        'is_system' => BoolEnum::NO
    );

    /**
     * 获取角色的所有权限
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_role','role_id','permission_id')->wherePivot('module',ModuleEnum::ADMIN);
    }
}
