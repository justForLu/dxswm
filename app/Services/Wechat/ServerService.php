<?php

namespace App\Services\Wechat;

use EasyWeChat\Work\Application;

class ServerService
{

    protected $app;

    /**
     * 初始化微信接口实例
     * @param $account
     * @param array $opts
     */
    public function initApp($account,$opts = array()){
        $options = array(
            'debug'   => true,
            'app_id'  => $account->app_id,         // AppID
            'secret'  => $account->app_secret,     // AppSecret
            'token'   => isset($account->token) ? $account->token : '',   // Token
            'aes_key' => isset($account->aes_key) ? $account->aes_key : '',    // EncodingAESKey，安全模式下请一定要填写！！！

            'log' => [
                'level' => 'error',
                'file'  => storage_path('logs/wechat') . '/wechat.log',
            ],
        );

        $this->app = new Application(array_merge($options,$opts));
    }
    /**
     * 获取微信支付
     * @param $account
     * @param $config
     * @return mixed
     */
    public function getPayment($account,$config){
        $opts = array(
            'payment' => [
                'merchant_id'        => $config['mch_id'],
                'key'                => $config['md5_key'],
                'notify_url'         => $config['notify_url'],       // 你也可以在下单时单独设置来想覆盖它
            ],
        );

        $this->initApp($account,$opts);

        return $this->app->payment;
    }

    /**
     * 发起网页授权
     * @param $account
     * @param $callback
     * @param string $scope
     * @return mixed
     */
    public function getOauth($account,$callback,$scope = 'snsapi_base'){
        $opts = array(
            'oauth' => [
                'scopes'   => [$scope],
                'callback' => $callback
            ],
        );

        $this->initApp($account,$opts);

        return $this->app->oauth;
    }

    /**
     * 获取用户服务
     * @param $account
     * @return mixed
     */
    public function getUser($account){
        $this->initApp($account);
        return $this->app->user;
    }

    /**
     * 获取模板消息服务
     * @param $account
     * @return mixed
     */
    public function getNotice($account){
        $this->initApp($account);
        return $this->app->notice;
    }

    /**
     * 获取JS SDK
     * @param $account
     * @return mixed
     */
    public function getJsApi($account){
        $this->initApp($account);
        return $this->app->js;
    }

    /**
     * @param $account
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Core\Exceptions\InvalidArgumentException
     */
    public function make($account)
    {

        $this->initApp($account);

        // 从项目实例中得到服务端应用实例。
        $server = $this->app->server;

        $server->setMessageHandler(function($message) use($account){

            if($message->MsgType == 'event'){
                // 处理事件
                return $this->handleEvent($account,$message);
            }else{
                // 处理消息
                return $this->handleMessage($account,$message);
            }

        });

        return $server->serve();
    }

    public function handleEvent($account,$message){
        return '';
    }

    public function handleMessage($account,$message){
        switch ($message->MsgType) {
            case 'event':  // 事件消息...
                #
                break;
            case 'text':   // 文字消息...
                #
                break;
            case 'image':  // 图片消息...
                #
                break;
            case 'voice':   // 语音消息...
                #
                break;
            case 'video':   // 视频消息...
                #
                break;
            case 'location':    // 坐标消息...
                #
                break;
            case 'link':    // 链接消息...
                #
                break;
            default:    // 其它消息
                # code...
                break;
        }

        return '';
    }
}
