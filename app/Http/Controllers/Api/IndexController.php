<?php

/**
 * 入口页
 * Class IndexController
 * @package App\Http\Controllers\Rcu
 */

namespace App\Http\Controllers\Api;

use App\Models\Common\School;
use App\Repositories\AccountsRepository as Accounts;
use App\Repositories\Api\UserRepository;
use App\Http\Controllers\Api\GoodsController as Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;

class IndexController extends BaseController
{

    protected $goods;

    public function __construct(UserRepository $userRepository,Request $request,Accounts $accounts, Goods $goods)
    {
        parent::__construct();

        $this->goods = $goods;

    }


    /**
     * 首页
     */
    public function index()
    {
        echo "Hello World";
        die();
    }

    /**
     * 返回首页需要的数据
     * @return mixed
     */
    public function getConfig()
    {
        $school_id = Cache::get(Config::get('api.school_id_key'));
        $school_id = $school_id ? $school_id : Config::get('api.default_school_id');   //默认第一个高校

        $school_info = School::find($school_id);

        $data['school_info'] = $school_info;

        return $this->ajaxSuccess($data,'OK');
    }

    /**
     * 切换高校
     * @param Request $request
     * @return mixed
     */
    public function school(Request $request)
    {
        $params = $request->all();

        $school_id = isset($params['school_id']) && !empty($params['school_id']) ? $params['school_id'] : 0;

        if($school_id){
            $school_id_key = Config::get('api.school_id_key');
            Cache::put($school_id_key, $school_id,10080);   //缓存学校ID

            return $this->ajaxSuccess($school_id_key,'切换高校成功');
        }

        return $this->ajaxError('切换高校失败');
    }

}




