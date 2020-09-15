<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BasicEnum;
use App\Models\Common\City;
use App\Http\Requests\Admin\SchoolRequest;
use App\Repositories\Admin\Criteria\SchoolCriteria;
use App\Repositories\Admin\SchoolRepository as School;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class SchoolController extends BaseController
{
    /**
     * @var School
     */
    protected $school;
    protected $log;

    public function __construct(School $school, LogRepository $log)
    {
        parent::__construct();

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

        $this->school->pushCriteria(new SchoolCriteria($params));

        $list = $this->school->paginate(Config::get('admin.page_size',10));

        if($list){
            $city_ids = [];
            foreach ($list as $value){
                $city_ids[] = $value['province'];
                $city_ids[] = $value['city'];
                $city_ids[] = $value['area'];
            }
            $city_ids = array_unique($city_ids);
            $city_list = [];
            if($city_ids){
                $city_list = City::whereIn('id',$city_ids)->pluck('title','id');
            }

            foreach ($list as &$v){
                $v['province_name'] = isset($city_list[$v['province']]) ? $city_list[$v['province']] : $v['province'];
                $v['city_name'] = isset($city_list[$v['city']]) ? $city_list[$v['city']] : $v['city'];
                $v['area_name'] = isset($city_list[$v['area']]) ? $city_list[$v['area']] : $v['area'];
            }
        }

        return view('admin.school.index',compact('params','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.school.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SchoolRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Bosnadev\Repositories\Exceptions\RepositoryException
     */
    public function store(SchoolRequest $request)
    {
        $params = $request->all();

        $data = [
            'name' => $params['name'] ?? '',
            'province' => $params['province'] ?? 0,
            'city' => $params['city'] ?? 0,
            'area' => $params['area'] ?? 0,
            'status' => $params['status'] ?? BasicEnum::ACTIVE,
            'create_time' => time()
        ];

        $result = $this->school->create($data);
        $this->log->writeOperateLog($request,'添加高校');   //日志记录

        return $this->ajaxAuto($result,'添加',url('admin/school'));
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
        $data = $this->school->find($id);
        $data->city = CityController::getCityArrString($data->area,'id');

        return view('admin.school.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SchoolRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SchoolRequest $request, $id)
    {
        $params = $request->filterAll();

        $data = [
            'name' => $params['name'] ?? '',
            'province' => $params['province'] ?? 0,
            'city' => $params['city'] ?? 0,
            'area' => $params['area'] ?? 0,
            'status' => $params['status'] ?? BasicEnum::ACTIVE,
            'update_time' => time()
        ];

        $result = $this->school->update($data,$id);
        $this->log->writeOperateLog($request,'编辑高校'); //日志记录

        return $this->ajaxAuto($result,'修改',url('admin/school'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->school->delete($id);

        return $this->ajaxAuto($result,'删除');
    }

    /**
     * 获取学校列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_school_list(Request $request)
    {
        $params = $request->all();

        $select = ['id','name'];

        $where = [];
        if(isset($params['province']) && $params['province'] > 0){
            $where['province'] = $params['province'];
        }
        if(isset($params['city']) && $params['city'] > 0){
            $where['city'] = $params['city'];
        }
        if(isset($params['area']) && $params['area'] > 0){
            $where['area'] = $params['area'];
        }

        $list = $this->school->getList($where, $select);

        return $this->ajaxSuccess($list);
    }
}
