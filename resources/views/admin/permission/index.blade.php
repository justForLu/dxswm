@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>权限管理</legend>
    </fieldset>

    <div class="main-toolbar">
        <div class="main-toolbar-item">
            @can('permission.create')
            <a href="{{url('admin/permission/create')}}" class="btn btn-sm bg-olive J_layer_dialog" title="创建权限">创建权限</a>
            @endcan
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <form action="{{url('admin/permission')}}" method="get" class="form-horizontal" role="form">
                <div class="col-sm-2">
                    <input type="text" name="name" class="form-control" placeholder="权限名称" value="{{ isset($params['name']) ?  $params['name'] : ''}}">
                </div>
                <div class="col-sm-1">
                    <button type="submit" id="search-btn" class="btn bg-olive">查询</button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>权限名称</th>
            <th>所属菜单</th>
            <th>权限编码</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->menu->name or ''}}</td>
                <td>{{$data->code}}</td>
                <td>
                    @can('permission.edit')
                    <a href="permission/{{$data->id}}/edit" class="btn bg-olive btn-xs J_layer_dialog" title="编辑权限"><i class="fa fa-edit"></i>编辑</a>
                    @endcan
                    @can('permission.destroy')
                    <a href="{{url('admin/permission',array($data->id))}}" class="btn btn-danger btn-xs J_layer_dialog_del" title="删除" data-token="{{ csrf_token() }}"><i class="fa fa-trash-o"></i>删除</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('admin.public.pages')
@endsection