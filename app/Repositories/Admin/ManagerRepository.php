<?php

namespace App\Repositories\Admin;


use App\Repositories\BaseRepository;

class ManagerRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Admin\Manager';
    }

    /**
     * 检查用户权限
     * @param $user
     * @param $permission
     * @return bool
     */
    public function hasPermission($user,$permission){
        $roles = $user->roles;

        if($roles){
            foreach($roles as $role){
                $permissions = array_column($role->permissions->toArray(),'id');
                if(in_array($permission->id,$permissions)) return true;
            }
            return false;
        }else{
            return false;
        }
    }
}
