<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\UserRepository as User;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    protected $user;

    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;

    }

    /**
     * 获取用户信息
     */
    public function getUser()
    {

    }

    /**
     * 获取我的收藏
     * @param Request $request
     */
    public function getCollect(Request $request)
    {

    }

    /**
     * 获取我的地址
     * @param Request $request
     */
    public function getAddress(Request $request)
    {

    }

    /**
     * 获取我的评价
     * @param Request $request
     */
    public function getEvaluate(Request $request){

    }
}




