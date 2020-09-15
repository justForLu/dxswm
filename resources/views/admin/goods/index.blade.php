@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>商品列表</legend>
    </fieldset>
    <div class="main-toolbar">
        @can('goods.create')
        <div class="main-toolbar-item"><a href="{{url('admin/goods/create')}}" class="btn btn-sm bg-olive">添加商品</a></div>
        @endcan
    </div>

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('admin/goods') }}" class="form-horizontal" role="form">
                <div class="col-sm-2">
                    <input type="text" name="name" autocomplete="off" class="form-control" placeholder="商品名称" value="{{ isset($params['name']) ?  $params['name'] : ''}}">
                </div>
                @if($business_id)
                <div class="col-sm-2">
                    <select name="category_id" class="form-control">
                        <option value="0">请选择分类</option>
                        @if($category)
                            @foreach($category as $v)
                                <option value="{{$v['id']}}" @if($v['id'] == (isset($params['category_id']) ? $params['category_id'] : 0)) selected @endif>{{$v['name']}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                @endif
                <div class="col-sm-2">
                    {{\App\Enums\GoodsEnum::enumSelect(isset($params['status']) ?  $params['status'] : '','请选择状态','status')}}
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
            <th>商品名称</th>
            <th>商品分类</th>
            <th>价格</th>
            <th>原价</th>
            <th>销量</th>
            <th>好评度</th>
            <th>排序</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->category_name}}</td>
                <td>{{$data->price}}</td>
                <td>{{$data->old_price}}</td>
                <td>{{$data->number}}</td>
                <td>{{$data->score}}</td>
                <td>{{$data->sort}}</td>
                <td>{{\App\Enums\GoodsEnum::getDesc($data->status)}}</td>
                <td>
                    @can('goods.edit')
                    <a href="goods/{{$data->id}}/edit" class="btn bg-olive btn-xs"><i class="fa fa-pencil"></i>编辑</a>
                    @endcan
                    @can('goods.destroy')
                    <a href="{{url('admin/goods',array($data->id))}}" class="btn btn-danger btn-xs J_layer_dialog_del" data-token="{{csrf_token()}}"><i class="fa fa-trash-o"></i>删除</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('admin.public.pages')
@endsection
