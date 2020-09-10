@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>管理员管理</legend>
    </fieldset>

    <div class="main-toolbar">
        <div class="main-toolbar-item">
            @can('manager.create')
            <a href="{{url('admin/manager/create')}}" class="btn btn-sm bg-olive" title="添加管理员">创建管理员</a>
            @endcan
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <form action="#" method="get" class="form-horizontal" role="form">
                <div class="col-sm-2">
                    <input type="text" name="username" class="form-control" placeholder="用户名" value="{{ isset($params['username']) ?  $params['username'] : ''}}">
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
            <th>用户名</th>
            <th>角色</th>
            <th>系统用户</th>
            <th>状态</th>
            <th>最新登录时间</th>
            <th>最新登录IP</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->username}}</td>
                <td>{{isset($data->roles[0]->name) ? $data->roles[0]->name : ''}}</td>
                <td>{{\App\Enums\BoolEnum::getDesc($data->is_system)}}</td>
                <td>{{\App\Enums\BasicEnum::getDesc($data->status)}}</td>
                <td>{{$data->gmt_last_login}}</td>
                <td>{{$data->last_ip}}</td>
                <td>{{$data->created_at}}</td>
                <td>
                    @can('manage.edit')
                    <a href="manager/{{$data->id}}/edit" class="btn bg-olive btn-xs"><i class="fa fa-pencil"></i>编辑</a>
                    @endcan
                    @if(!$data->is_system)
                        @if($data->id != Auth::user()->id)
                            @can('manager.destroy')
                            <a href="{{url('admin/manager',array($data->id))}}" class="btn btn-danger btn-xs J_layer_dialog_del" data-token="{{csrf_token()}}"><i class="fa fa-trash-o"></i>删除</a>
                            @endcan
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        @include('admin.public.pages')
    </table>
@endsection