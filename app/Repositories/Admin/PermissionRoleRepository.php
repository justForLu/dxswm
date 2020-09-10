<?php

namespace App\Repositories\Admin;


use App\Repositories\BaseRepository;

class PermissionRoleRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Admin\PermissionRole';
    }


    /**
     * 批量插入角色权限关系
     * @param $permissions
     * @param $role
     * @return mixed
     */
    public function addPermissionRoles($permissions,$role){
        $permissionRoles = array();

        foreach($permissions as $val){
            $permissionRoles[] = array(
                'permission_id' => $val,
                'role_id' => $role->id,
                'module' => $role->module
            );
        }

        return $this->insertBatch($permissionRoles);
    }

    /**
     * 批量删除角色权限关系
     * @param $permissions
     * @param $role
     * @return mixed
     */
    public function delPermissionRoles($permissions,$role){
        return $this->model->where(function($query) use($permissions,$role){
                                $query->where('role_id',$role->id)
                                      ->whereIn('permission_id',$permissions);
                            })->delete();
    }

    /**
     * 获取角色的权限
     * @param $role_id
     * @return mixed
     */
    public function getRolePermissions($role_id){
        return $this->model->where('role_id', $role_id)->pluck('permission_id')->toArray();
    }
}
