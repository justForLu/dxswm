<?php

namespace App\Repositories\Api;

use App\Enums\ModuleEnum;
use App\Enums\OrderActionEnum;
use App\Enums\OrderEnum;
use App\Models\Common\Address;
use App\Models\Common\Business;
use App\Models\Common\Cart;
use App\Models\Common\Goods;
use App\Models\Common\Order;
use App\Models\Common\OrderAction;
use App\Models\Common\OrderGoods;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Order';
    }

    /**
     * 获取订单列表（有分页）
     * @param array $params
     * @param string $field
     * @return mixed
     */
    public function getList($params = [], $field = '*')
    {
        if(!isset($params['user_id']) || empty($params['user_id'])){
            return -1;
        }

        $where = [];
        $where[] = ['user_id', $params['user_id']];
        if(isset($params['status']) && !empty($params['status'])){
            $where[] = ['status',$params['status']];
        }




    }

    /**
     * 根据订单ID获取订单详情
     * @param int $id
     * @param string $field
     */
    public function getOrderById($id = 0, $field = '*')
    {

    }

    /**
     * 创建订单（页面部分）
     * @param array $params
     * @return mixed
     */
    public function createOrder($params = [])
    {
        if(!isset($params['business_id']) || empty($params['business_id'])){
            return -1;
        }
        if(!isset($params['user_id']) || empty($params['user_id'])){
            return -1;
        }

        //订单提交的数据
        $submit_data = [
            'address_id' => 0,
            'goods_id' => []
        ];

        //获取地址，如果有默认地址则取默认地址，否则取最新地址
        $address = [];
        $address_list = Address::select('address.*', 'school.name as school_name')
            ->join('school', 'address.school_id', '=', 'school.id')
            ->where('address.user_id',$params['user_id'])
            ->orderBy('address.id','DESC')
            ->get()->toArray();
        if($address_list){
            foreach ($address_list as $k => $v){
                if($k == 0){
                    $address = $v;
                }
                if($v['is_default'] == 1){
                    $address = $v;
                }
            }
        }

        $submit_data['address_id'] = isset($address['id']) ? $address['id'] : 0;

        //店家信息
        $business_info = Business::select('id','name','image')->where('id',$params['business_id'])->first();
        if($business_info){
            $business_info->image = Config::get('api.api_url').$business_info->image;
        }

        //商品信息
        $goods_list = [];
        $total_info = [     //总计信息
            'goods_money' => 0, //商品金额
            'pay_money' => 0,   //实付金额
        ];
        $cart_info = Cart::select('goods')
            ->where('user_id',$params['user_id'])
            ->where('business_id', $params['business_id'])
            ->first();

        if(isset($cart_info['goods']) && !empty($cart_info['goods'])){
            $goods_cart = json_decode($cart_info['goods'], true);
            $goods_num = [];
            if($goods_cart){
                foreach ($goods_cart as $num){
                    $goods_num[$num['goods_id']] = $num;
                }
            }
            $goods_ids = array_unique(array_column($goods_cart, 'goods_id'));
            if($goods_ids){
                $goodsList = Goods::select('id','name','image','price')
                    ->whereIn('id', $goods_ids)
                    ->get()->toArray();
                $goods_money = 0;
                $pay_money = 0;
                if($goodsList){
                    foreach ($goodsList as &$val){
                        $val['number'] = isset($goods_num[$val['id']]['number']) ? $goods_num[$val['id']]['number'] : 0;
                        $val['image'] = Config::get('api.api_url').$val['image'];

                        $goods_list[] = $val;
                        $goods_money += $val['price']*$val['number'];
                        $pay_money += $val['price']*$val['number'];

                        $submit_data['goods_id'][] = ['goods_id' => $val['id'], 'number' => $val['number']];
                    }
                }

                $total_info['goods_money'] = $goods_money;
                $total_info['pay_money'] = $pay_money;
            }

        }

        return ['address' => $address, 'business' => $business_info, 'goods' => $goods_list, 'total' => $total_info, 'submit' => $submit_data];
    }

    /**
     * 确认提交订单
     * @param array $params
     * @return mixed
     */
    public function submitOrder($params = [])
    {
        if(!isset($params['user_id']) || empty($params['user_id'])){
            return ['data' => '', 'code' => -1, 'msg' => '提交订单有误'];
        }
        if(!isset($params['address_id']) || empty($params['address_id'])){
            return ['data' => '', 'code' => -1, 'msg' => '提交订单有误'];
        }
        if(!isset($params['goods_id']) || empty($params['goods_id'])){
            return ['data' => '', 'code' => -1, 'msg' => '提交订单有误'];
        }
        if(!isset($params['business_id']) || empty($params['business_id'])){
            return ['data' => '', 'code' => -1, 'msg' => '提交订单有误'];
        }

        //收货地址
        $address_info = Address::where('id', $params['address_id'])->first();
        if(empty($address_info) || $address_info->user_id != $params['user_id']){
            return ['data' => '', 'code' => -2, 'msg' => '收货地址有误'];
        }
        //商品信息
        $order_goods = [];  //order_goods表的数据
        $goods_num = $params['goods_id'];   //goods_id和购买数量number的数组

        $order_money = 0;   //订单金额
        $total_num = 0; //商品总数量
        if(is_array($goods_num)){
            $goods_ids = array_column($params['goods_id'], 'goods_id');
            $goods_num = set_index($goods_num,'goods_id');
            $goods_list = Goods::whereIn('id',$goods_ids)->get();
            if($goods_list){
                foreach ($goods_list as $v){
                    //检查商品状态等信息
                    if($v['status'] != 1){
                        return ['data' => '', 'code' => -3, 'msg' => '商品已下架'];
                    }
                    if($v['business_id'] != $params['business_id']){
                        return ['data' => '', 'code' => -4, 'msg' => '商品与店家信息不匹配'];
                    }
                    $goods_number = $goods_num[$v['id']]['number'] ?? 0;
                    if($goods_number <= 0){
                        return ['data' => '', 'code' => -5, 'msg' => '商品数量有误'];
                    }
                    $order_money += $v['price'] * $goods_number;
                    $total_num += $goods_number;
                    $order_goods[] = [
                        'goods_id' => $v['id'],
                        'goods_name' => $v['name'],
                        'old_price' => $v['old_price'],
                        'price' => $v['price'],
                        'number' => $goods_number,
                        'create_time' => time()
                    ];
                }
            }
        }

        if(empty($order_goods)){
            return ['data' => '', 'code' => -6, 'msg' => '商品信息有误'];
        }

        //生成订单编号
        $order_code = $this->createOrderCode();

        $order_data = [
            'business_id' => $params['business_id'],
            'order_code' => $order_code,
            'user_id'   => $params['user_id'],
            'order_money' => $order_money,
            'pay_money' => 0,
            'discount_money' => 0,
            'mobile' => $address_info->mobile,
            'school_id' => $address_info->school_id,
            'address' => $address_info->address,
            'user_name' => $address_info->name,
            'number' => $total_num,
            'order_time' => time(),
            'status' => OrderEnum::UNPAID,
            'remark' => $params['remark'] ?? '',
            'create_time' => time(),
        ];

        //开启事务
        DB::beginTransaction();

        //插入订单
        $order_id = $this->model->insertGetId($order_data);
        if(!$order_id){
            DB::rollBack();
            return ['data' => '', 'code' => -7, 'msg' => '提交订单失败'];
        }
        //插入订单商品
        foreach ($order_goods as &$value){
            $value['order_id'] = $order_id;
        }
        $res_goods = OrderGoods::insert($order_goods);
        if(!$res_goods){
            DB::rollBack();
            return ['data' => '', 'code' => -7, 'msg' => '提交订单失败'];
        }
        //订单操作日志
        $action_data = [
            'order_id' => $order_id,
            'user_id' => $params['user_id'],
            'order_status' => OrderEnum::UNPAID,
            'action_place' => ModuleEnum::HOME,
            'action_type' => OrderActionEnum::SUBMIT,
            'action_note' => '提交订单',
            'create_time' => time(),
        ];
        $res_action = OrderAction::insert($action_data);
        if(!$res_action){
            DB::rollBack();
            return ['data' => '', 'code' => -7, 'msg' => '提交订单失败'];
        }

        DB::commit();
        return ['data' => $order_id, 'code' => 0, 'msg' => '提交订单成功'];
    }

    /**
     * 订单支付
     * @param array $params
     * @return mixed
     */
    public function payOrder($params = [])
    {

    }

    /**
     * 订单确认收货
     * @param array $params
     * @return mixed
     */
    public function confirmOrder($params = [])
    {

    }

    /**
     * 订单评价
     * @param array $params
     * @return mixed
     */
    public function evaluateOrder($params = [])
    {

    }

    /**
     * 生成订单编号
     * @return mixed
     */
    public function createOrderCode()
    {
        while (1){
            $order_code = date('YmdHis').mt_rand(10000,99999);

            //检查是否存在的订单号
            $is_exist = Order::where('order_code', $order_code)->count();

            if(!$is_exist){
                return $order_code;
            }
        }

    }
}
