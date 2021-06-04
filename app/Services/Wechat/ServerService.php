<?php

namespace App\Services\Wechat;

use EasyWeChat\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class ServerService
{

    protected $app;
    protected $server;
    protected $config;

    public function __construct()
    {
        $this->config = [
            'debug'   => true,
            'app_id'  => 'wxea44dfe442267485',         // AppID
            'secret'  => '522409447b99deee8c74fe594416ee22',     // AppSecret
            'token'   => Config::get('admin.token'),   // Token
            'aes_key' => '6ocQuKCWh5Y1sYebMvKML7YYyXxn07LIs49XJWwy4xk',    // EncodingAESKey，安全模式下请一定要填写！！！
            'response_type' => 'array',

            'log' => [
                'default' => 'dev', // 默认使用的 channel，生产环境可以改为下面的 prod
                'channels' => [
                    // 测试环境
                    'dev' => [
                        'driver' => 'single',
                        'path' => storage_path('logs/wechat') . '/wechat.log',
                        'level' => 'debug',
                    ],
                    // 生产环境
                    'prod' => [
                        'driver' => 'daily',
                        'path' => storage_path('logs/wechat') . '/wechat.log',
                        'level' => 'info',
                    ],
                ],
            ],
        ];

        $this->app = Factory::officialAccount($this->config);
        $this->server = $this->app->server;

        //判断AccessToken是否存在，不存在则获取一下
        $access_token = Cache::get('access_token');
        if(!$access_token){
            $this->getAccessToken();
        }
    }

    /**
     * 获取access_token
     */
    public function getAccessToken()
    {
        $accessToken = $this->app->access_token;
        $token = $accessToken->getToken(); // token 数组  token['access_token'] 字符串
        if(isset($token['access_token']) && !empty($token['access_token'])){
            Cache::put('access_token', $token['access_token'], 7190);
        }
    }

    /**
     * 获取菜单列表
     * @return mixed
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getMenuList()
    {
        $list = $this->app->menu->list();

        return $list;
    }

    /**
     * 创建菜单
     * @param array $buttons
     * @return mixed
     */
    public function createMenu($buttons = [])
    {
        $buttons = [
            [
                "name"       => "找工作",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "找工作",
                        "url"  => env('H5_URL')
                    ]
                ],
            ],
            [
                "name"       => "找门店",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "找门店",
                        "url"  => env('H5_URL')."/pages/shop/shop"
                    ],
                ],
            ],
            [
                "name"       => "个人中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "报名",
                        "url"  => env('H5_URL')."/pages/user/user"
                    ],
                    [
                        "type" => "view",
                        "name" => "我的工资",
                        "url"  => env('H5_URL')."/pages/user/user"
                    ]
                ],
            ],
        ];
        $this->app->menu->create($buttons);

        $response = $this->app->server->serve();
        return $response->send();
    }

    /**
     * 发起网页授权
     * @param $callback
     * @param string $scope
     * @return mixed
     */
    public function getOauth($callback = null, $scope = 'snsapi_userinfo')
    {
        $response = $this->app->oauth->scopes([$scope])
            ->redirect($callback);

        return $response;
    }

    /**
     * 获取用户信息
     * @return mixed
     */
    public function getUser(){
        $user = $this->app->user;
        $user = json_decode(json_encode($user), true);
        return $user;
    }

    /**
     * 用户授权之后返回地址获取用户信息
     * @return array|\Overtrue\Socialite\Providers\WeChatProvider|\Overtrue\Socialite\User
     */
    public function oauthCallback()
    {
        $user = $this->app->oauth->user();
        $user = $user->getOriginal();

        return $user;
    }


}
