@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>店家列表</legend>
    </fieldset>
    <div class="main-toolbar">
        @can('business.create')
        <div class="main-toolbar-item"><a href="{{url('admin/business/create')}}" class="btn btn-sm bg-olive">添加店家</a></div>
        @endcan
    </div>

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('admin/business') }}" class="form-horizontal" role="form">
                <div class="col-sm-2">
                    <input type="text" name="name" autocomplete="off" class="form-control" placeholder="店家名称" value="{{ isset($params['name']) ?  $params['name'] : ''}}">
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-1 control-label">行政区划</label>
                    <input type="hidden" id="city_id" name="city_id" value="">
                    <div class="col-sm-2">
                        <select name="province" data-url="{{url('admin/get_city_list')}}" data-init="true"
                                data-value="" data-target="subCity" data-val="city_id" class="form-control J_ajax_select">
                            <option>省</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select name="city" data-val="city_id" id="subCity" data-url="{{url('admin/get_city_list')}}"
                                data-value=""  data-target="subDistinct"  class="form-control J_ajax_select">
                            <option>市</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select name="area" data-val="city_id" id="subDistinct" data-url="{{url('admin/get_city_list')}}"
                                data-value="" data-target="thrCity" class="form-control J_ajax_select">
                            <option>区</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    {{\App\Enums\BusinessEnum::enumSelect(isset($params['status']) ?  $params['status'] : null,'请选择状态','status')}}
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
            <th>店家名称</th>
            <th>关联管理员</th>
            <th>店铺手机号</th>
            <th>省份</th>
            <th>城市</th>
            <th>县/区</th>
            <th>销量</th>
            <th>好评率</th>
            <th>业务员</th>
            <th>状态</th>
            <th>添加日期</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->admin_name}}</td>
                <td>{{$data->mobile}}</td>
                <td>{{$data->province_name}}</td>
                <td>{{$data->city_name}}</td>
                <td>{{$data->area_name}}</td>
                <td>{{$data->number}}</td>
                <td>{{$data->score}}</td>
                <td>{{$data->salesman['name']}}</td>
                <td>{{\App\Enums\BusinessEnum::getDesc($data->status)}}</td>
                <td>{{$data->create_time}}</td>
                <td>
                    @can('business.edit')
                    <a href="business/{{$data->id}}/edit" class="btn bg-olive btn-xs"><i class="fa fa-pencil"></i>编辑</a>
                    @endcan
                    @can('business.destroy')
                    <a href="{{url('admin/business',array($data->id))}}" class="btn btn-danger btn-xs J_layer_dialog_del" data-token="{{csrf_token()}}"><i class="fa fa-trash-o"></i>删除</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('admin.public.pages')
@endsection
