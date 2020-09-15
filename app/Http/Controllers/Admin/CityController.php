<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BasicEnum;
use App\Repositories\Admin\Criteria\CityCriteria;
use App\Repositories\Admin\CityRepository as City;
use App\Repositories\Admin\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CityController extends BaseController
{
    /**
     * @var City
     */
    protected $city;
    protected $log;

    public function __construct(City $city, LogRepository $log)
    {
        parent::__construct();

        $this->city = $city;
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

        $this->city->pushCriteria(new CityCriteria($params));

        $list = $this->city->paginate(Config::get('admin.page_size',10));

        return view('admin.city.index',compact('params','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $data = $this->city->find($id);

        return view('admin.city.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();

        $data = [
            'status' => $params['status'] ?? BasicEnum::ACTIVE,
            'update_time' => time()
        ];

        $result = $this->city->update($data,$id);
        $this->log->writeOperateLog($request,'修改城市状态'); //日志记录

        return $this->ajaxAuto($result,'修改',url('admin/city'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 获取区域id上级区域
     *
     * @param Request|Request $request
     * @return \Illuminate\Http\Response
     */
    public function get_city_path(Request $request)
    {
        $id = $request->input('id');
        $list = $this->city->get_city_path($id);

        return response()->json($list);
    }

    /**
     * 获取区域id下级区域
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function get_city_list(Request $request){
        $id = $request->input('id');
        if(!isset($id) || empty($id)){
            $params['parent'] = 0;
            $params['grade'] = 1;
        }else{
            $params['parent'] = $id;
        }

        $list = $this->city->getCityList($params);
        return response()->json($list);
    }

    /**
     * 根据城市id获取与该城市关联的省市区等信息
     * @param $id
     * @param $type
     * @return array
     */
    static function getCityArrString($id,$type = 'arr'){
        $cityLabel = array('province','city','area');
        $cityArr = array();
        $cityId = array();
        $cityName='';

        do{
            $city = \App\Models\Common\City::select('*')->where('id',$id)->first($id);
            if($city){
                $cityArr[$cityLabel[$city->grade-1]] = $city->title;
                $cityId[$cityLabel[$city->grade-1]] = $city->id;
                $cityName=$city->title.$cityName;
                $id = $city->parent;
            }
        }while(isset($city->parent) && $city->parent != 0);

        if($type == 'string'){
            return $cityName;//返回字符串
        }elseif($type == 'id'){
            return $cityId;//返回ID
        }else{
            return $cityArr;//返回数组
        }
    }

}
