@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>分类管理</legend>
    </fieldset>
    <div class="main-toolbar">
        @can('category.create')
        <div class="main-toolbar-item"><a href="{{url('admin/category/create')}}" class="btn btn-sm bg-olive" title="创建分类">创建分类</a></div>
        @endcan
    </div>

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('admin/category') }}" class="form-horizontal" role="form">
                <div class="col-sm-2">
                    <input type="text" name="name" autocomplete="off" class="form-control" placeholder="分类名称" value="{{ isset($params['name']) ?  $params['name'] : ''}}">
                </div>
                <div class="col-sm-2">
                    {{\App\Enums\CategoryEnum::enumSelect(isset($params['type']) ?  $params['type'] : '','请选择分类','type')}}
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
            <th>分类类型</th>
            <th>分类名称</th>
            <th>店家名称</th>
            <th>排序</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{\App\Enums\CategoryEnum::getDesc($data->type)}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->business_name}}</td>
                <td>{{$data->sort}}</td>
                <td>{{\App\Enums\BasicEnum::getDesc($data->status)}}</td>
                <td>
                    @can('category.edit')
                    <a href="category/{{$data->id}}/edit" class="btn bg-olive btn-xs"><i class="fa fa-pencil"></i>编辑</a>
                    @endcan
                    @can('category.destroy')
                    <a href="{{url('admin/category',array($data->id))}}" class="btn btn-danger btn-xs J_layer_dialog_del" data-token="{{csrf_token()}}"><i class="fa fa-trash-o"></i>删除</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('admin.public.pages')
@endsection
