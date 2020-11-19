<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\CartRepository as Cart;
use Illuminate\Http\Request;

class CartController extends BaseController
{

    protected $cart;

    public function __construct(Cart $cart)
    {
        parent::__construct();

        $this->cart = $cart;

    }

    /**
     * 获取购物车列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCart(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $list = $this->cart->getCart($params);
        if($list == -1){
            return $this->ajaxError('获取失败');
        }

        return $this->ajaxSuccess($list,'OK');
    }

    /**
     * 加入购物车
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCart(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $result = $this->cart->addCart($params);
        if($result == -1){
            return $this->ajaxError('加入购物车失败');
        }

        return $this->ajaxAuto($result, '加入购物车');
    }

    /**
     * 清空购物车
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function emptyCart(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = 1;

        $result = $this->cart->delCart($params);
        if($result == -1){
            return $this->ajaxError('缺少参数');
        }

        return $this->ajaxAuto($result, '清空购物车');
    }
}




