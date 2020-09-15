@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>用户列表</legend>
    </fieldset>
    <div class="main-toolbar">
    </div>

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('admin/user') }}" class="form-horizontal" role="form">
                <div class="col-sm-2">
                    <input type="text" name="nickname" autocomplete="off" class="form-control" placeholder="用户昵称" value="{{ isset($params['nickname']) ?  $params['nickname'] : ''}}">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="mobile" autocomplete="off" class="form-control" placeholder="手机号" value="{{ isset($params['mobile']) ?  $params['mobile'] : ''}}">
                </div>
                <div class="col-sm-2">
                    {{\App\Enums\BoolEnum::enumSelect(isset($params['is_rider']) ?  $params['is_rider'] : -1,'是否是骑手','is_rider')}}
                </div>
                <div class="col-sm-2">
                    {{\App\Enums\BoolEnum::enumSelect(isset($params['is_business']) ?  $params['is_business'] : -1,'是否是店家','is_business')}}
                </div>
                <div class="col-sm-2">
                    {{\App\Enums\BasicEnum::enumSelect(isset($params['status']) ?  $params['status'] : '','请选择状态','status')}}
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
            <th>昵称</th>
            <th>性别</th>
            <th>手机号</th>
            <th>上次登录时间</th>
            <th>是否商家</th>
            <th>是否骑手</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->nickname}}</td>
                <td>{{\App\Enums\GenderEnum::getDesc($data->gender)}}</td>
                <td>{{$data->mobile}}</td>
                <td>{{$data->login_time}}</td>
                <td>{{\App\Enums\BoolEnum::getDesc($data->is_business)}}</td>
                <td>{{\App\Enums\BoolEnum::getDesc($data->is_rider)}}</td>
                <td>{{\App\Enums\BasicEnum::getDesc($data->status)}}</td>
                <td>
                    @can('user.edit')
                    <a href="user/{{$data->id}}/edit" class="btn bg-olive btn-xs"><i class="fa fa-pencil"></i>编辑</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('admin.public.pages')
@endsection
