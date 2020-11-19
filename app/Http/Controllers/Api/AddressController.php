<?php

namespace App\Http\Controllers\Api;

use App\Enums\BusinessEnum;
use App\Http\Requests\Api\AddressRequest;
use App\Models\Common\School;
use App\Repositories\Api\AddressRepository as Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class AddressController extends BaseController
{

    protected $address;

    public function __construct(Address $address)
    {
        parent::__construct();

        $this->address = $address;

    }

    /**
     * 获取地址列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \ReflectionException
     */
    public function getList(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $field = ['id','name','mobile','school_id','address','is_default'];
        $list = $this->address->getList($params,$field);
        if($list){
            $schoolList = [];
            $school_ids = array_unique(array_column($list, 'school_id'));
            if($school_ids){
                $schoolList = School::whereIn('id',$school_ids)->pluck('name','id');
            }

            foreach ($list as &$v){
                if(isset($schoolList[$v['school_id']])){
                    $v['school_name'] = $schoolList[$v['school_id']];
                }
            }
        }

        return $this->ajaxSuccess($list,'OK');
    }


    /**
     * 保存地址信息
     * @param AddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAddress(AddressRequest $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $ret = $this->address->saveAddress($params);
        if($ret == -1){
            return $this->ajaxError('保存失败');
        }

        return $this->ajaxAuto($ret,'保存');
    }

    /**
     * 获取地址信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $data = $this->address->getInfo($params);

        return $this->ajaxSuccess($data,'OK');
    }

    /**
     * 修改地址信息
     * @param AddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updAddress(AddressRequest $request)
    {
        $params = $request->all();

        if(!isset($params['id']) || empty($params['id'])){
            return $this->ajaxError('确实参数ID');
        }

        $ret = $this->address->updAddress($params);

        return $this->ajaxAuto($ret,'保存');
    }

}




