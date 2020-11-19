<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BasicEnum;
use App\Enums\BusinessEnum;
use App\Enums\ManagerTypeEnum;
use App\Http\Requests\Admin\BusinessRequest;
use App\Models\Admin\Manager;
use App\Models\Admin\RoleUser;
use App\Models\Common\City;
use App\Repositories\Admin\Criteria\BusinessCriteria;
use App\Repositories\Admin\BusinessRepository as Business;
use App\Repositories\Admin\SalesmanRepository as Salesman;
use App\Repositories\Admin\SchoolRepository as School;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BusinessController extends BaseController
{
    /**
     * @var Business
     */
    protected $business;
    protected $salesman;
    protected $school;
    protected $log;

    public function __construct(Business $business, Salesman $salesman, School $school, LogRepository $log)
    {
        parent::__construct();

        $this->business = $business;
        $this->salesman = $salesman;
        $this->school = $school;
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

        $this->business->pushCriteria(new BusinessCriteria($params));

        $list = $this->business->with(array('salesman'))->paginate(Config::get('admin.page_size',10));

        if($list){
            //处理关键的管理员和省市等信息
            $admin_id = [];
            $region_id = [];
            foreach ($list as $value){
                $admin_id[] = $value['admin_id'];
                $region_id[] = $value['province'];
                $region_id[] = $value['city'];
                $region_id[] = $value['area'];
            }
            $admin_id = array_unique($admin_id);
            $region_id = array_unique($region_id);
            $admin_list = [];
            $region_list = [];
            if($admin_id){
                $admin_list = Manager::select('id','username','real_name')->whereIn('id',$admin_id)->get()->toArray();
                $admin_list = set_index($admin_list,'id');
            }
            if($region_id){
                $region_list = City::whereIn('id',$region_id)->pluck('title','id');
                $region_list = set_index($region_list,'id');
            }

            foreach ($list as &$v){
                $v['admin_name'] = isset($admin_list[$v['admin_id']]) ? (!empty($admin_list[$v['admin_id']]['real_name']) ? $admin_list[$v['admin_id']]['real_name'] : $admin_list[$v['admin_id']]['username']) : $v['admin_id'];
                $v['province_name'] = isset($region_list[$v['province']]) ? $region_list[$v['province']] : $v['province'];
                $v['city_name'] = isset($region_list[$v['city']]) ? $region_list[$v['city']] : $v['city'];
                $v['area_name'] = isset($region_list[$v['area']]) ? $region_list[$v['area']] : $v['area'];
            }

        }

        return view('admin.business.index',compact('params','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $salesman = $this->salesman->getList();

        return view('admin.business.create',compact('salesman'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BusinessRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Bosnadev\Repositories\Exceptions\RepositoryException
     */
    public function store(BusinessRequest $request)
    {
        $params = $request->all();

        if($params['password'] != $params['re_password']){
            return $this->ajaxError('两次密码不一致');
        }

        //先把管理员账号插入到manager中，然后再把店铺账号插入到business表
        DB::beginTransaction();

        $data_admin = [
            'username' => $params['username'],
            'password' => Hash::make($params['password']),
            'status' => BasicEnum::ACTIVE,
            'type' => ManagerTypeEnum::BUSINESS,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $admin_id = Manager::insertGetId($data_admin);

        if($admin_id){
            //处理封面图片链接地址，存储封面图片链接
            $image_path = array_values(FileController::getFilePath($params['image']));
            $image_path = $image_path[0] ?? '';
            $data = [
                'admin_id' => $admin_id,
                'name' => $params['name'] ?? '',
                'mobile' => $params['mobile'] ?? '',
                'image' => $image_path,
                'province' => $params['province'] ?? '',
                'city' => $params['city'] ?? 0,
                'area' => $params['area'] ?? 0,
                'school' => $params['school'] ?? '',
                'address' => $params['address'] ?? '',
                'time_limit' => $params['time_limit'] ?? '',
                'notice' => $params['notice'] ?? '',
                'status' => $params['status'] ?? BusinessEnum::OPEN,
                'salesman_id' => $params['salesman_id'] ?? 0,
                'create_time' => time()
            ];

            $result = $this->business->create($data);
            if($result){
                DB::commit();
                $this->log->writeOperateLog($request,'添加店铺');   //日志记录

                return $this->ajaxSuccess(null,'添加成功',url('admin/business'));
            }
            DB::rollBack();
            return $this->ajaxError('添加失败');

        }else{
            DB::rollBack();
            return $this->ajaxError('添加失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
        $data = $this->business->find($id);
        $role = RoleUser::where('user_id',Auth::user()->id)->first();
        $role_id = $role['role_id'];

        //管理员
        $admin = Manager::select('username','real_name')->where('id',$data->admin_id)->first();
        $data->admin_name = isset($admin['real_name']) && !empty($admin['real_name']) ? $admin['real_name'] : $admin['username'];

        //高校
        $select_s = ['id','name'];
        $where_s = [];
        if($data->province){
            $where_s['province'] = $data->province;
        }
        if($data->city){
            $where_s['city'] = $data->city;
        }
        if($data->area){
            $where_s['area'] = $data->area;
        }

        $school = $this->school->getList($where_s, $select_s);
        if($school){
            foreach ($school as &$v){
                if($v['id'] == $data->school){
                    $v['selected'] = true;
                }else{
                    $v['selected'] = false;
                }
            }
        }

        //业务员
        $salesman = $this->salesman->getList();
        if($salesman){
            foreach ($salesman as $name){
                if($data->salesman_id == $name['id']){
                    $data->salesman_name = $name['name'];
                }
            }
        }

        //行政区划（必须放后面，不然会有影响）
        $data->city = CityController::getCityArrString($data->area,'id');

        return view('admin.business.edit',compact('data','school','salesman','role_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BusinessRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BusinessRequest $request, $id)
    {
        $params = $request->filterAll();

        //处理封面链接地址，存储封面链接
        if(strlen($params['image']) > 20){
            $image_path = $params['image'];
        }else{
            $image_path = array_values(FileController::getFilePath($params['image']));
            $image_path = $image_path[0] ?? '';
        }

        $data = [
            'name' => $params['name'] ?? '',
            'mobile' => $params['mobile'] ?? '',
            'image' => $image_path,
            'province' => $params['province'] ?? '',
            'city' => $params['city'] ?? 0,
            'area' => $params['area'] ?? 0,
            'school' => $params['school'] ?? '',
            'address' => $params['address'] ?? '',
            'time_limit' => $params['time_limit'] ?? '',
            'notice' => $params['notice'] ?? '',
            'status' => $params['status'] ?? BusinessEnum::OPEN,
            'salesman_id' => $params['salesman_id'] ?? 0,
            'update_time' => time()
        ];

        $result = $this->business->update($data,$id);
        $this->log->writeOperateLog($request,'编辑店铺'); //日志记录

        return $this->ajaxAuto($result,'修改',url('admin/business'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->business->delete($id);

        return $this->ajaxAuto($result,'删除');
    }

}
