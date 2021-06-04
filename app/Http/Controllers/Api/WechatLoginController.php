<?php

namespace App\Http\Controllers\Api;

use App\Services\Wechat\ServerService as Server;
use App\Repositories\Api\UserRepository as User;
use Illuminate\Http\Request;

class WechatLoginController extends BaseController
{

    protected $user;
    protected $server;
    protected $collect;
    protected $address;
    protected $evaluate;

    public function __construct(Server $server, User $user)
    {
        parent::__construct();

        $this->user = $user;
        $this->server = $server;

    }

    /**
     * 微信公众号、小程序静默授权登陆
     * @return \Illuminate\Http\JsonResponse
     */
    public function oauthLogin()
    {
        $url = env('APP_URL').'/api/index/oauth_callback';
        $this->server->getOauth($url);
    }

    /**
     * 微信公众号、小程序静默登陆回调
     * @throws \ReflectionException
     */
    public function oauthCallback()
    {
        $user = $this->server->oauthCallback();
        if($user){
            return $this->user->silentLogin($user);
        }
    }

    /**
     * 微信公众号、小程序静默登陆操作
     */
    public function silentLogin()
    {

    }

}




