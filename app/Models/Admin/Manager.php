<?php

namespace App\Models\Admin;

use App\Enums\BasicEnum;
use App\Enums\BoolEnum;
use App\Enums\ModuleEnum;
use App\Models\Base;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Manager extends Authenticatable
{
    use Notifiable;

    // 模型对应表名
    protected $table = 'manager';

    protected $fillable = ['id','username','password','remember_token','gmt_last_login','last_ip','status','parent','path','is_system'];

    protected $attributes = array(
        'status' => BasicEnum::ACTIVE,
        'is_system' => BoolEnum::NO
    );

    /**
     * 获取管理员的角色
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany(Role::class,'role_user','user_id','role_id')->wherePivot('module',ModuleEnum::ADMIN);
    }
}
