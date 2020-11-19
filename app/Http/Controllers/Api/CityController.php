<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\CityRepository as City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;


class CityController extends BaseController
{

    protected $city;

    public function __construct(City $city)
    {
        parent::__construct();

        $this->city = $city;

    }

    /**
     * 获取城市列表
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $params = $request->all();

        $list = $this->city->getList($params);

        return $this->ajaxSuccess($list,'OK');
    }

}




