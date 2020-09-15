@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>订单列表</legend>
    </fieldset>
    <div class="main-toolbar">
    </div>

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('admin/order') }}" class="form-horizontal" role="form">
                <div class="col-sm-2">
                    <input type="text" name="order_code" autocomplete="off" class="form-control" placeholder="订单编号" value="{{ isset($params['order_code']) ?  $params['order_code'] : ''}}">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="mobile" autocomplete="off" class="form-control" placeholder="收货人手机号" value="{{ isset($params['mobile']) ?  $params['mobile'] : ''}}">
                </div>
                <div class="col-sm-2">
                    {{\App\Enums\OrderEnum::enumSelect(isset($params['status']) ?  $params['status'] : '','请选择订单状态','status')}}
                </div>
                <div class="col-sm-1">
                    <button type="submit" class="btn bg-olive">搜索</button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>订单号</th>
            <th>商家名称</th>
            <th>购买用户</th>
            <th>骑手</th>
            <th>订单总额</th>
            <th>优惠金额</th>
            <th>实付金额</th>
            <th>支付方式</th>
            <th>商品数量</th>
            <th>下单时间</th>
            <th>支付时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->order_code}}</td>
                <td>{{$data->business_name}}</td>
                <td>{{$data->user_name}}</td>
                <td>{{$data->rider_name}}</td>
                <td>{{$data->order_money}}</td>
                <td>{{$data->discount_money}}</td>
                <td>{{$data->pay_money}}</td>
                <td>{{\App\Enums\PayTypeEnum::getDesc($data->pay_type)}}</td>
                <td>{{$data->number}}</td>
                <td>{{$data->order_time}}</td>
                <td>{{$data->pay_time}}</td>
                <td>{{\App\Enums\OrderEnum::getDesc($data->status)}}</td>
                <td>
                    @can('order.edit')
                    <a href="order/{{$data->id}}/edit" class="btn bg-olive btn-xs"><i class="fa fa-pencil"></i>编辑</a>
                    @endcan
                    @can('order.destroy')
                    <a href="{{url('admin/order',array($data->id))}}" class="btn btn-danger btn-xs J_layer_dialog_del" data-token="{{csrf_token()}}"><i class="fa fa-trash-o"></i>删除</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('admin.public.pages')
@endsection
