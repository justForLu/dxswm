<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BoolEnum;
use App\Enums\ModuleEnum;
use App\Http\Requests\Admin\ManagerRequest;
use App\Models\Admin\RoleUser;
use App\Repositories\Admin\Criteria\ManagerCriteria;
use App\Repositories\Admin\Criteria\RoleCriteria;
use App\Repositories\Admin\ManagerRepository as Manager;
use App\Repositories\Admin\RoleRepository as Role;
use App\Repositories\Admin\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerController extends BaseController
{

    /**
     * @var Role
     */
    protected $role;

    /**
     * @var Manager
     */
    protected $manager;

    protected $log;

    public function __construct(Role $role,Manager $manager, LogRepository $log)
    {
        parent::__construct();

        $this->role = $role;
        $this->manager = $manager;
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

        if(Auth::user()->is_system == BoolEnum::NO){
            $params['parent'] = $this->currentUser['id'];
        }
        $this->manager->pushCriteria(new ManagerCriteria($params));

        $list = $this->manager->with(array('roles'))->paginate(Config::get('admin.page_size',10));
        return view('admin.manager.index',compact('params','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $params = array();
        if(Auth::user()->is_system == BoolEnum::NO){
            $params['parent'] = $this->currentUser->roles[0]->id;
        }

        $this->role->pushCriteria(new RoleCriteria($params));
        $roleList = $this->role->all();
        return view('admin.manager.create',compact('roleList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ManagerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ManagerRequest $request)
    {
        $params = $request->filterAll();

        DB::beginTransaction();
        $params['password'] = Hash::make($params['password']);
        $data = $this->manager->create($params);

        if($data){
            if($data->parent == 0){
                $data['path'] = '0,'. $data->id . ',';
            }else{
                $parentData = $this->manager->findBy('id', $data->parent);
                $data['path'] = $parentData->path . $data->id . ',';
            }

            $flag = $this->manager->update($data->getAttributes(), $data->id);

            $flag1 = RoleUser::create(array('user_id'=>$data['id'],'role_id'=>$params['role_id'],'module'=>ModuleEnum::ADMIN))->save();

            if($flag && $flag1){
                DB::commit();
                $this->log->writeOperateLog($request,'添加管理员');  //日志记录
                return $this->ajaxSuccess(null,'添加成功',url('admin/manager'));
            }else{
                DB::rollBack();
                return $this->ajaxError('添加失败');
            }
        }else{
            DB::rollBack();
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
        //
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

        if($this->currentUser->is_system) {
            $roleList = $this->role->all();
        } else {
            $params['parent'] = $this->currentUser->roles[0]->id;
            $this->role->pushCriteria(new RoleCriteria($params));
            $roleList = $this->role->findAllBy('is_system',0);
        }
        $data = $this->manager->with(array('roles'))->find($id);

        return view('admin.manager.edit',compact('data','params','roleList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ManagerRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ManagerRequest $request, $id)
    {
        $data = $request->filterAll();

        DB::beginTransaction();
        if(isset($data['password']) && !empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
        }
        $role_id = $data['role_id'];unset($data['role_id']);

        $parentData = $this->manager->findBy('id', $data['parent']);

        if($parentData){
            $data['path'] = $parentData->path . $id . ',';
        }
        $result = $this->manager->update($data,$id);

        if($result !== false){
            $roleUser = RoleUser::where('user_id',$id)->first();

            if($roleUser){
                $roleUser->role_id = $role_id;

                $flag = RoleUser::where('id',$roleUser['id'])->update($roleUser->toArray());

                if($flag !== false){
                    DB::commit();
                    $this->log->writeOperateLog($request,'更新管理员信息');    //日志记录
                    return $this->ajaxSuccess(null,'更新成功',url('admin/manager'));
                }else{
                    DB::rollBack();
                    return $this->ajaxError('更新失败');
                }
            }else{
                DB::rollBack();
                return $this->ajaxError('更新失败');
            }
        }else{
            DB::rollBack();
            return $this->ajaxError('更新失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $result = $this->manager->delete($id);

        if($result){
            $flag = RoleUser::where('user_id',$id)->delete();

            if($flag){
                DB::commit();
                return $this->ajaxSuccess(null,'删除成功');
            }else{
                DB::rollBack();
                return $this->ajaxError('删除失败');
            }
        }else{
            DB::rollBack();
            return $this->ajaxError('删除失败');
        }
    }
}
