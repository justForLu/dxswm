<?php
namespace App\Services;

use App\Services\Wechat\ServerService as Server;
use EasyWeChat\Payment\Order;

class PayService
{
    protected $payment;

    protected $server;

    protected $wxconfig;

    public function __construct(Server $server)
    {
        $config = array();
        $account = session('cur_account');
        $config['app_id'] = $account->app_id;
        $config['mch_id'] = $account->mch_id;
        $config['md5_key'] = $account->pay_secret;

        $this->server = $server;
        $this->wxconfig = array_merge(config('hotel.wxpay'),$config);
    }


    /**
     * 获取统一下单id
     * @param $account
     * @param $params
     * @return bool
     */
    public function get_prepay_id($account,$params){
        $this->payment = $this->server->getPayment($account,$this->wxconfig);

        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => '民宿酒店',
            'detail'           => '民宿酒店订单支付',
            'out_trade_no'     => $params['order_no'],
            'total_fee'        => intval($params['cost'] * 100),    // 订单金额，单位为分
            'openid'           => $params['openid'] // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];
        $order = new Order($attributes);

        $result = $this->payment->prepare($order);

        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            return $result->prepay_id;
        }else{
            return false;
        }
    }

    /**
     * 生成JS支付签名包
     * @param $account
     * @param $prepayId
     * @return mixed
     */
    public function get_js_package($account,$prepayId){
        $this->payment = $this->server->getPayment($account,$this->wxconfig);

        $package = $this->payment->configForPayment($prepayId);

        return $package;
    }

    /**
     * 处理微信支付结果
     * @param $account
     * @param $callback
     * @return mixed
     */
    public function handle_pay_notify($account,$callback){
        $this->payment = $this->server->getPayment($account,$this->wxconfig);

        $response = $this->payment->handleNotify($callback);

        return $response;
    }


}