@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>城市列表</legend>
    </fieldset>

    <div class="main-toolbar">
        <div class="main-toolbar-item">
            @if(isset($params['parent']) && $params['parent'] > 0)
                <a href="{{ url('admin/city') }}" class="btn btn-sm bg-default">回到列表首页</a>
                <a href="javascript:history.back();" class="btn btn-sm bg-olive"><i class="fa fa-reply" aria-hidden="true"></i></a>
            @endif
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <form action="{{ url('admin/city') }}" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="parent" value="{{ isset($params['parent']) ?  $params['parent'] : ''}}">
                <div class="col-sm-2">
                    <input type="text" name="title" class="form-control" placeholder="区域名称" value="{{ isset($params['title']) ?  $params['title'] : ''}}">
                </div>
                <div class="col-sm-1">
                    <button type="submit" id="search-btn" class="btn btn-sm bg-olive">查询</button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>区域名称</th>
            <th>父节点</th>
            <th>等级</th>
            <th>排序</th>
            @if ( isset( $list[0]->grade ) ? ( $list[0]->grade < 3) : 0)
                <th>子级</th>
            @endif
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $data)
            <tr>
                <td>{{ $data->id }}</td>
                <td>{{ $data->title }}</td>
                <td>{{ $data->parent }}</td>
                <td>{{ $data->grade }}</td>
                <td>{{ $data->sort }}</td>
                @if ( isset($data->grade ) ? ($data->grade < 3) : 0)
                    <td>
                        <a href="{!! route('city.index',['parent' => $data->id ]) !!}">[子级区域]</a>
                    </td>
                @endif
                <td>
                    @can('city.edit')<a href="category/{{$data->id}}/edit" class="btn bg-olive btn-xs J_layer_dialog" title="编辑区域"><i class="fa fa-edit"></i>编辑</a>@endcan
                    @if ( isset($data->grade ) ? ($data->grade == 3) : 0)
                        @can('city.destroy')<a href="{{url('admin/category',array($data->id))}}" class="btn btn-danger btn-xs J_layer_dialog_del" title="删除" data-token="{{ csrf_token() }}"><i class="fa fa-trash-o"></i>删除</a>@endcan
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('admin.public.pages')
@endsection
