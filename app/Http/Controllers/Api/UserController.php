<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\UserRepository as User;
use App\Repositories\Api\CollectRepository as Collect;
use App\Repositories\Api\AddressRepository as Address;
use App\Repositories\Api\EvaluateRepository as Evaluate;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    protected $user;
    protected $collect;
    protected $address;
    protected $evaluate;

    public function __construct(User $user,Collect $collect,Address $address,Evaluate $evaluate)
    {
        parent::__construct();

        $this->user = $user;
        $this->collect = $collect;
        $this->address = $address;
        $this->evaluate = $evaluate;

    }

    /**
     * 获取用户信息
     */
    public function getUser(Request $request)
    {
        $user_id = 1;
        $user_info = $this->user->getUserById($user_id);

        return $this->ajaxSuccess($user_info,'OK');
    }

    /**
     * 获取我的收藏
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCollect(Request $request)
    {
        $params = $request->all();

        $list = $this->collect->getList($params);

        return $this->ajaxSuccess($list, 'OK');
    }

    /**
     * 获取我的地址
     */
    public function getAddress()
    {
        $params['user_id'] = 1;

        $list = $this->address->getList($params);

        return $this->ajaxSuccess($list,'OK');
    }

    /**
     * 获取我的评价
     * @param Request $request
     */
    public function getEvaluate(Request $request){

    }
}




