<?php

namespace App\Repositories\Admin;


use App\Enums\ModuleEnum;
use App\Models\Admin\Manager;
use App\Models\Admin\Menu;
use App\Repositories\Admin\Criteria\MenuCriteria;
use App\Repositories\BaseRepository;
use App\Services\TreeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MenuRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Admin\Menu';
    }

    /**
     * 获取用户的菜单树
     * @return array
     */
    public function getUserMenuTree(){
        $menuTree = array();

        if(Auth::guard()->user()->is_system){
            // 系统用户分配所有权限
            $params['module'] = ModuleEnum::ADMIN;
            $menuList = $this->pushCriteria(new MenuCriteria($params))->all();

            $menuTree = TreeService::makeTree($menuList);
        }else{
            // 创建用户分配指定权限
            $roles = Auth::guard()->user()->roles;

            if($roles){
                // 找出登录用户的所有权限id
                $permissions = $menu_ids = array();

                foreach($roles as $role){
                    $permissions = array_merge($permissions,array_column($role->permissions->toArray(),'id'));
                    $menu_ids = array_merge($menu_ids,array_column($role->permissions()->distinct('menu_id')->get()->toArray(),'menu_id'));
                }

                if(count($permissions) && count($menu_ids)){
                    $menu_paths = implode(',',array_column(Menu::whereIn('id',$menu_ids)->select('path')->get()->toArray(),'path'));
                    $menus = array_filter(explode(',', $menu_paths));

                    $menu_items = Menu::whereIn('id',$menus)->get();

                    $menuTree = TreeService::makeTree($menu_items);
                }
            }
        }

        return $menuTree;
    }
}
