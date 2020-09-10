@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>菜单管理</legend>
    </fieldset>

    <div class="main-toolbar">
        @can('menu.create')
        <div class="main-toolbar-item"><a href="{{url('admin/menu/create')}}" class="btn btn-sm bg-olive J_layer_dialog" title="创建菜单">创建菜单</a></div>
        @endcan
    </div>

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('admin/menu') }}" class="form-horizontal" role="form">
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                <input type="hidden" name="module" value="{{$params['module']}}">
                <label class="col-sm-1 control-label">菜单名称</label>
                <div class="col-sm-2">
                    <input type="text" name="name" autocomplete="off" class="form-control" placeholder="菜单名称" value="{{ isset($params['name']) ?  $params['name'] : ''}}">
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
            <th>菜单名称</th>
            <th>菜单地址</th>
            <th>菜单编码</th>
            <th>菜单等级</th>
            <th>菜单状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->url}}</td>
                <td>{{$data->code}}</td>
                <td>{{$data->grade}}</td>
                <td>{{\App\Enums\BasicEnum::getDesc($data->status)}}</td>
                <td>
                    @can('menu.edit')
                    <a href="menu/{{$data->id}}/edit" class="btn bg-olive btn-xs J_layer_dialog"><i class="fa fa-pencil"></i>编辑</a>
                    @endcan
                    @can('menu.destroy')
                    <a href="{{url('admin/menu',array($data->id))}}" class="btn btn-danger btn-xs J_layer_dialog_del" data-token="{{csrf_token()}}"><i class="fa fa-trash-o"></i>删除</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('admin.public.pages')
@endsection