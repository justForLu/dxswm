<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Repositories\Api\UserRepository as User;
use Illuminate\Http\Request;

class LoginController extends BaseController
{

    protected $user;

    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;

    }

    /**
     * 普通登陆
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \ReflectionException
     */
    public function appLogin(LoginRequest $request)
    {
        $params = $request->all();

        $result = $this->user->appLogin($params);

        if(isset($result['code']) && $result['code'] < 0){
            return $this->ajaxError($result['msg']);
        }

        return $this->ajaxSuccess($result,'登陆成功');
    }

    /**
     * 普通用户注册
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function appRegister(RegisterRequest $request)
    {
        $params = $request->all();

        $result = $this->user->appRegister($params);

        if(isset($result['code']) && $result['code'] < 0){
            return $this->ajaxError($result['msg']);
        }

        return $this->ajaxSuccess($result,'登陆成功');
    }

    /**
     * 发送验证码
     * @param Request $request
     */
    public function sendCode(Request $request)
    {

    }

}




