@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>日志管理</legend>
    </fieldset>

    <div class="main-toolbar">
        <div class="main-toolbar-item">
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <form action="#" method="get" class="form-horizontal" role="form">

            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>管理员名称</th>
            <th>请求地址</th>
            <th>日志内容</th>
            <th>IP</th>
            <th>时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->username}}</td>
                <td>{{$data->operate_url}}</td>
                <td>{{$data->content}}</td>
                <td>{{$data->ip}}</td>
                <td>{{$data->create_time}}</td>
            </tr>
        @endforeach
        </tbody>
        @include('admin.public.pages')
    </table>
@endsection