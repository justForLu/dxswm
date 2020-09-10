@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>反馈管理</legend>
    </fieldset>

    <div class="main-toolbar">
        <div class="main-toolbar-item">
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <form action="#" method="get" class="form-horizontal" role="form">
                <div class="col-sm-2">
                    <input type="text" name="name" class="form-control" placeholder="姓名" value="{{ isset($params['name']) ?  $params['name'] : ''}}">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="mobile" class="form-control" placeholder="手机号" value="{{ isset($params['mobile']) ?  $params['mobile'] : ''}}">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="email" class="form-control" placeholder="邮箱" value="{{ isset($params['email']) ?  $params['email'] : ''}}">
                </div>
                <div class="col-sm-2">
                    {{\App\Enums\FeedbackEnum::enumSelect(isset($params['status']) ?  $params['status'] : '','处理状态','status')}}
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
            <th>姓名</th>
            <th>手机号</th>
            <th>邮箱</th>
            <th>反馈内容</th>
            <th>状态</th>
            <th>备注</th>
            <th>处理人</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->mobile}}</td>
                <td>{{$data->email}}</td>
                <td>{{$data->content}}</td>
                <td>{{\App\Enums\FeedbackEnum::getDesc($data->status)}}</td>
                <td>{{$data->remark}}</td>
                <td>{{$data->admin_name}}</td>
                <td>
                    @can('feedback.edit')
                    <a href="feedback/{{$data->id}}/edit" class="btn bg-olive btn-xs"><i class="fa fa-pencil"></i>查看</a>
                    @endcan
                        @can('feedback.destroy')
                            <a href="{{url('admin/feedback',array($data->id))}}" class="btn btn-danger btn-xs J_layer_dialog_del" data-token="{{csrf_token()}}"><i class="fa fa-trash-o"></i>删除</a>
                        @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
        @include('admin.public.pages')
    </table>
@endsection