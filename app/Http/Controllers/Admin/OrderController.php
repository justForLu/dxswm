<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderEnum;
use App\Http\Requests\Admin\OrderRequest;
use App\Models\Common\Business;
use App\Models\Common\City;
use App\Models\Common\OrderAction;
use App\Models\Common\OrderGoods;
use App\Models\Common\School;
use App\Models\Common\User;
use App\Repositories\Admin\Criteria\OrderCriteria;
use App\Repositories\Admin\OrderRepository as Order;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    /**
     * @var Order
     */
    protected $order;
    protected $log;

    public function __construct(Order $order, LogRepository $log)
    {
        parent::__construct();

        $this->order = $order;
        $this->log = $log;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $this->order->pushCriteria(new OrderCriteria($params));

        $list = $this->order->paginate(Config::get('admin.page_size',10));

        if($list){
            //商家名称
            $business_id = [];
            //购买用户&骑手
            $user_id = [];
            foreach ($list as $value){
                $business_id[] = $value['business_id'];
                $user_id[] = $value['user_id'];
                $user_id[] = $value['rider_id'];
            }
            $business_list = [];
            $user_list = [];
            if($business_id){
                $business_id = array_unique($business_id);
                $business_list = Business::whereIn('id',$business_id)->pluck('name','id');
            }
            if($user_id){
                $user_id = array_unique($user_id);
                $user_list = User::whereIn('id',$user_id)->pluck('nickname','id');
            }

            foreach ($list as &$v){
                $v['business_name'] = isset($business_list[$v['business_id']]) ? $business_list[$v['business_id']] : '';
                $v['user_name'] = isset($user_list[$v['user_id']]) ? $user_list[$v['user_id']] : '';
                $v['rider_name'] = isset($user_list[$v['rider_id']]) ? $user_list[$v['rider_id']] : '';
                $v['order_time'] = $v['order_time'] > 0 ? date('Y-m-d H:i:s', $v['order_time']) : '';
                $v['pay_time'] = $v['pay_time'] > 0 ? date('Y-m-d H:i:s', $v['pay_time']) : '';
            }
        }


        return view('admin.order.index',compact('params','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     */
    public function store(OrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $data = $this->order->find($id);
        //商家
        $business = Business::select('id','name')->where('id',$data->business_id)->first();
        $data->business_name = isset($business->name) ? $business->name : '';

        //购买用户&骑手
        $user_id = [$data->user_id, $data->rider_id];
        $user_list = User::whereIn('id',$user_id)->pluck('nickname','id');
        $data->user_name = isset($user_list[$data->user_id]) ? $user_list[$data->user_id] : '';
        $data->rider_name = isset($user_list[$data->rider_id]) ? $user_list[$data->rider_id] : '';

        //省市县
        $region_id = [$data->province,$data->city,$data->area];
        $region_list = City::whereIn('id',$region_id)->pluck('title','id');
        $data->province_name = isset($region_list[$data->province]) ? $region_list[$data->province] : '';
        $data->city_name = isset($region_list[$data->city]) ? $region_list[$data->city] : '';
        $data->area_name = isset($region_list[$data->area]) ? $region_list[$data->area] : '';

        //高校
        $schoolInfo = School::select('id','name')->where('id',$data->school)->first();
        $data->school_name = isset($schoolInfo->name) ? $schoolInfo->name : '';

        //处理时间
        $data->order_time = $data->order_time > 0 ? date('Y-m-d H:i:s', $data->order_time) : '';
        $data->pay_time = $data->pay_time > 0 ? date('Y-m-d H:i:s', $data->pay_time) : '';
        $data->cancel_time = $data->cancel_time > 0 ? date('Y-m-d H:i:s', $data->cancel_time) : '';

        //订单商品
        $goods_list = OrderGoods::where('order_id',$data->id)->get();
        //订单操作记录
//        $action_list = OrderAction::where('order_id',$data->id)->get();

        return view('admin.order.edit',compact('data','goods_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(OrderRequest $request, $id)
    {
        $params = $request->filterAll();

        $data = [
            'status' => $params['status'] ?? OrderEnum::UNPAID,
            'remark' => $params['remark'] ?? '',
            'update_time' => time()
        ];

        $result = $this->order->update($data,$id);
        $this->log->writeOperateLog($request,'编辑订单'); //日志记录

        return $this->ajaxAuto($result,'编辑',url('admin/order'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     */
    public function destroy($id)
    {
        //
    }
}
