<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\GoodsRepository as Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class GoodsController extends BaseController
{

    protected $goods;

    public function __construct(Goods $goods)
    {
        parent::__construct();

        $this->goods = $goods;

    }

    /**
     * 商品列表
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $params = $request->all();
        $school_id = Cache::get(Config::get('api.school_id_key'));
        $school_id = $school_id ? $school_id : Config::get('api.default_school_id');
        $params['school_id'] = $school_id;

        $list = $this->goods->getList($params);

        if($list){
            foreach ($list as &$v){
                $v['image'] = Config::get('api.api_url').$v['image'];
            }
        }

        return $this->ajaxSuccess($list,'OK');
    }

}




