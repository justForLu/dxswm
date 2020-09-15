@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>业务员列表</legend>
    </fieldset>

    <div class="main-toolbar">
        @can('salesman.create')
        <div class="main-toolbar-item"><a href="{{url('admin/salesman/create')}}" class="btn btn-sm bg-olive J_layer_dialog" data-w="500px" title="添加业务员">添加业务员</a></div>
        @endcan
    </div>

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('admin/salesman') }}" class="form-horizontal" role="form">
                <div class="col-sm-2">
                    <input type="text" name="name" autocomplete="off" class="form-control" placeholder="业务员姓名" value="{{ isset($params['name']) ?  $params['name'] : ''}}">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="mobile" autocomplete="off" class="form-control" placeholder="业务员手机号" value="{{ isset($params['mobile']) ?  $params['mobile'] : ''}}">
                </div>
                <div class="col-sm-2">
                    {{\App\Enums\BasicEnum::enumSelect(isset($params['status']) ? $params['status'] : null,'选择状态','status')}}
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
            <th>业务员姓名</th>
            <th>手机号</th>
            <th>微信号</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->mobile}}</td>
                <td>{{$data->weixin}}</td>
                <td>{{\App\Enums\BasicEnum::getDesc($data->status)}}</td>
                <td>
                    @can('salesman.edit')
                    <a href="salesman/{{$data->id}}/edit" class="btn bg-olive btn-xs J_layer_dialog" data-w="500px"><i class="fa fa-pencil"></i>编辑</a>
                    @endcan
                    @can('salesman.destroy')
                    <a href="{{url('admin/salesman',array($data->id))}}" class="btn btn-danger btn-xs J_layer_dialog_del" data-token="{{csrf_token()}}"><i class="fa fa-trash-o"></i>删除</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('admin.public.pages')
@endsection
