<?php

namespace App\Http\Controllers\Api;

use App\Enums\BusinessEnum;
use App\Models\Common\School;
use App\Repositories\Api\BusinessRepository as Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class BusinessController extends BaseController
{

    protected $business;

    public function __construct(Business $business)
    {
        parent::__construct();

        $this->business = $business;
    }

    /**
     * 获取店家列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \ReflectionException
     */
    public function getList(Request $request)
    {
        $params = $request->all();
        $school_id = Cache::get(Config::get('api.school_id_key'));
        $school_id = $school_id ? $school_id : Config::get('api.default_school_id');
        $params['school_id'] = $school_id;

        $list = $this->business->getList($params);

        if($list['list']){
            foreach ($list['list'] as &$v){
                $v['image'] = Config::get('api.api_url').$v['image'];
                $v['status_name'] = BusinessEnum::getDesc($v['status']);
                $v['score'] = $v['score'].'%';
            }
        }

        return $this->ajaxSuccess($list,'OK');
    }


    /**
     * 获取店家信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request)
    {
        $params = $request->all();

        $data = $this->business->getInfo($params);
        //获取学校名称
        if($data){
            $school_info = School::where('id', $data->school)->pluck('name');
            $data->school_name = $school_info[0] ?? '';
        }else{
            $data->school_name = '';
        }

        return $this->ajaxSuccess($data,'OK');
    }

    /**
     * 收藏/取消收藏店铺
     * @param Request $request
     */
    public function collectBusiness(Request $request)
    {

    }

}




