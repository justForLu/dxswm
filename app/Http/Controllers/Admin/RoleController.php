<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BoolEnum;
use App\Enums\ModuleEnum;
use App\Http\Requests\Admin\AuthorityRequest;
use App\Http\Requests\Admin\RoleRequest;
use App\Repositories\Admin\PermissionRepository as Permission;
use App\Repositories\Admin\Criteria\MenuCriteria;
use App\Repositories\Admin\Criteria\RoleCriteria;
use App\Repositories\Admin\RoleRepository as Role;
use App\Repositories\Admin\MenuRepository as Menu;
use App\Repositories\Admin\PermissionRoleRepository as PermissionRole;
use App\Repositories\Admin\LogRepository;
use App\Services\TreeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class RoleController extends BaseController
{
    /**
     * @var Role
     */
    protected $role;
    /**
     * @var Menu
     */
    protected $menu;
    /**
     * @var Permission
     */
    protected $permission;
    /**
     * @var PermissionRole
     */
    protected $permissionRole;

    protected $log;

    public function __construct(Role $role,Menu $menu,Permission $permission,PermissionRole $permissionRole,LogRepository $log)
    {
        parent::__construct();

        $this->role = $role;
        $this->menu = $menu;
        $this->permission = $permission;
        $this->permissionRole = $permissionRole;
        $this->log = $log;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $params['module'] = isset($params['module']) ? $params['module'] : ModuleEnum::ADMIN;

        if(Auth::user()->is_system == BoolEnum::NO){
            $params['parent'] = $this->currentUser->roles[0]->id;
        }
        $this->role->pushCriteria(new RoleCriteria($params));

        $list = $this->role->paginate(Config::get('admin.page_size',10));

        // 获取所有模块
        $modules = ModuleEnum::enumItems();
        return view('admin.role.index',compact('params','list','modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $params = $request->all();
        $params['module'] = isset($params['module']) ? $params['module'] : ModuleEnum::ADMIN;

        $role_id = $this->currentUser->roles[0]->id;

        return view('admin.role.create',compact('params','role_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $data = $request->filterAll();

        if(empty($data['name'])){
            return $this->ajaxError('请输入角色名称');
        }

        $data = $this->role->create($data);

        if($data){
            if($data->parent == 0){
                $data['path'] = '0,'. $data->id . ',';
            }else{
                $parentData = $this->role->findBy('id', $data->parent);
                $data['path'] = $parentData->path . $data->id . ',';
            }

            $flag = $this->role->update($data->getAttributes(), $data->id);

            if($flag){
                $this->log->writeOperateLog($request,'添加角色');   //日志记录
                return $this->ajaxSuccess(null,'添加成功');
            }else{
                return $this->ajaxError('添加失败');
            }
        }else{
            return $this->ajaxError('添加失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return view('admin.role.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $params = $request->all();
        $params['id'] = $id;

        $data = $this->role->find($id);
        return view('admin.role.edit',compact('data','params'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, $id)
    {
        $data = $request->filterAll();

        if(empty($data['name'])){
            return $this->ajaxError('请输入角色名称');
        }

        $parentData = $this->role->findBy('id', $data['parent']);

        if($parentData){
            $data['path'] = $parentData->path . $id . ',';
        }
        $result = $this->role->update($data,$id);
        $this->log->writeOperateLog($request,'编辑角色');   //日志记录

        return $this->ajaxAuto($result,'修改');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->role->delete($id);

        return $this->ajaxAuto($result,'删除');
    }

    /**
     * @param AuthorityRequest $request
     * @param TreeService $tree
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function authority(AuthorityRequest $request,TreeService $tree,$id = 0)
    {
        $params = $request->filterAll();

        $role = $this->role->find(isset($params['role_id']) ? $params['role_id'] : $id);
        $params['permissions'] = isset($params['permissions']) ? $params['permissions'] : array();
        $rolePermissions = $this->permissionRole->getRolePermissions($role->id);

        if($request->isMethod('GET') && $id){
            // 视图页面
            $params['module'] = $role->module;
            $params['role_id'] = $id;
            $params['is_system'] = BoolEnum::NO;

            $permissions = $menu_ids = array();

            if(Auth::user()->is_system == BoolEnum::NO){
                // 非系统角色只能分配当前角色所有的权限,找出登录用户的角色信息
                $roles = Auth::user()->roles;

                foreach($roles as $role){
                    $permissions = array_merge($permissions,array_column($role->permissions->toArray(),'id'));
                    $menu_ids = array_merge($menu_ids,array_column($role->permissions()->groupBy('menu_id')->get()->toArray(),'menu_id'));
                }

                $menu_ids = array_merge($menu_ids,array_column(\App\Models\Admin\Menu::whereIn('id',$menu_ids)->groupBy('parent')->get()->toArray(),'parent'));
                $params['menu_ids'] = $menu_ids;
            }

            $this->menu->pushCriteria(new MenuCriteria($params));
            $menuList = $this->menu->with(array('permissions'))->all();

            // 勾选权限默认选中
            foreach($menuList as $key => $val){
                $menuPermission = $val->permissions;

                if(!empty($menuPermission)){
                    foreach($menuPermission as $itemKey => $itemVal){
                        if(Auth::user()->is_system == BoolEnum::NO){
                            if(in_array($itemVal['id'],$permissions)){
                                if(in_array($itemVal['id'],$rolePermissions)){
                                    $menuList[$key]->permissions[$itemKey]['checked'] = "checked=true";
                                    $menuList[$key]->permissions[$itemKey]['active'] = "checkbox-active";
                                }else{
                                    $menuList[$key]->permissions[$itemKey]['checked'] = '';
                                    $menuList[$key]->permissions[$itemKey]['active'] = '';
                                }
                            }else{
                                unset($menuList[$key]->permissions[$itemKey]);
                            }
                        }else{
                            if(in_array($itemVal['id'],$rolePermissions)){
                                $menuList[$key]->permissions[$itemKey]['checked'] = "checked=true";
                                $menuList[$key]->permissions[$itemKey]['active'] = "checkbox-active";
                            }else{
                                $menuList[$key]->permissions[$itemKey]['checked'] = '';
                                $menuList[$key]->permissions[$itemKey]['active'] = '';
                            }
                        }
                    }

                    $flag = count(array_diff(array_column($menuPermission->toArray(),'id'),$rolePermissions));
                    $menuList[$key]['checked'] = $flag ? '' : "checked=checked";
                    $menuList[$key]['active'] = $flag ? '' : "checkbox-active";

                }
            }

            $menuList = $tree::makeTree($menuList);

            return view('admin.role.authority',compact('role','menuList','params'));
        }else{
            // 操作页面
            $delRolePermissions = array_diff($rolePermissions,$params['permissions']);
            $addRolePermissions = array_diff($params['permissions'],$rolePermissions);

            $exception = DB::transaction(function() use($delRolePermissions,$addRolePermissions,$params,$role){
                // 删除旧的数据
                if(count($delRolePermissions)){
                    $this->permissionRole->delPermissionRoles($delRolePermissions,$role);
                }

                // 增加新的数据
                if(count($addRolePermissions)){
                    $this->permissionRole->addPermissionRoles($addRolePermissions,$role);
                }

            });

            $result = is_null($exception) ? true : false;
            if($result){
                return $this->ajaxAuto($result,'提交', url('admin/role'));
            }
            return $this->ajaxAuto($result,'提交');
        }
    }
}
