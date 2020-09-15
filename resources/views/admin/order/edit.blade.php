@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>编辑订单</legend>
    </fieldset>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/order',array($data->id))}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">商家名称</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->business_name}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">订单编号</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->order_code}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">购买用户</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->user_name}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">骑手</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->rider_name}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">订单总额</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->order_money}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">优惠金额</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->discount_money}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">实付金额</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->pay_money}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">支付方式</label>
                                <div class="col-sm-8 form-control-static">
                                    {{\App\Enums\PayTypeEnum::getDesc($data->pay_type)}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">收货人</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->user_name}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">收货人手机号</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->mobile}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">省份</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->province_name}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">城市</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->city_name}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">区/县</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->area_name}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">高校</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->school_name}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">收货地址</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->address}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">商品数量</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->number}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">下单时间</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->order_time}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">支付时间</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->pay_time}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">取消时间</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->cancel_time}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-3 control-label">交易流水号</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->transaction_id}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sort" class="col-sm-3 control-label">备注</label>
                            <div class="col-sm-8">
                                <textarea name="remark" class="form-control" cols="50" rows="5">{{$data->remark}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">状态</label>
                            <div class="col-sm-8">
                                {{\App\Enums\OrderEnum::enumSelect($data->status,false,'status')}}
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-xs-2 col-md-1 col-sm-offset-3">
                                @can('order.update')
                                    <button type="submit" class="btn btn-primary J_ajax_submit_btn">提交</button>
                                @endcan
                            </div>
                            <div class="col-xs-2 col-md-1">
                                <a href="{{url('admin/order')}}" class="btn btn-default">取消</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <fieldset class="main-field main-field-title">
            <legend>订单商品</legend>
        </fieldset>
        <div class="row" style="padding-bottom: 50px;">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>商品ID</th>
                        <th>商品名称</th>
                        <th>商品价格</th>
                        <th>商品原价</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($goods_list as $goods)
                            <tr>
                                <td>{{$goods->goods_id}}</td>
                                <td>{{$goods->goods_name}}</td>
                                <td>{{$goods->price}}</td>
                                <td>{{$goods->old_price}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
{{--        <fieldset class="main-field main-field-title">--}}
{{--            <legend>订单操作记录</legend>--}}
{{--        </fieldset>--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <table class="table table-bordered table-striped">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>订单状态</th>--}}
{{--                        <th>操作位置</th>--}}
{{--                        <th>操作类型</th>--}}
{{--                        <th>操作详情</th>--}}
{{--                        <th>操作时间</th>--}}
{{--                        <th>查看备注</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                        @foreach ($action_list as $action)--}}
{{--                            <tr>--}}
{{--                                <td>{{$action->order_status}}</td>--}}
{{--                                <td>{{$action->action_place}}</td>--}}
{{--                                <td>{{$action->action_type}}</td>--}}
{{--                                <td>{{$action->action_note}}</td>--}}
{{--                                <td>{{$action->create_time}}</td>--}}
{{--                                <td>{{$action->remark}}</td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
    </section>
@endsection



