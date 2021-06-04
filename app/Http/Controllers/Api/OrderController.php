<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\OrderRepository as Order;
use Illuminate\Http\Request;

class OrderController extends BaseController
{

    protected $order;

    public function __construct(Order $order)
    {
        parent::__construct();

        $this->order = $order;

    }

    /**
     * 订单列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderList(Request $request)
    {
        $params = $request->all();

        $list = $this->order->getList($params);

        return $this->ajaxSuccess($list,'OK');
    }

    /**
     * 创建订单（页面）
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $data = $this->order->createOrder($params);

        if($data == -1){
            return $this->ajaxError('信息有误');
        }

        return $this->ajaxSuccess($data,'OK');
    }

    /**
     * 提交订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitOrder(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $result = $this->order->submitOrder($params);
        if($result['code'] == 0){
            return $this->ajaxSuccess($result['data'],'订单提交成功');
        }

        return $this->ajaxError($result['msg']);
    }

    /**
     * 订单支付
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payOrder(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $result = $this->order->payOrder($params);

        return $this->ajaxSuccess($result,'OK');
    }

    /**
     * 确认收货
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmOrder(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $result = $this->order->confirmOrder($params);

        return $this->ajaxSuccess($result,'OK');
    }

    /**
     * 订单评价
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluateOrder(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $result = $this->order->evaluateOrder($params);

        return $this->ajaxSuccess($result,'OK');
    }

}




