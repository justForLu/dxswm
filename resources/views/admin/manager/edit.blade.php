@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>修改管理员</legend>
    </fieldset>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/manager',array($data->id))}}" method="post">
                    <div class="box-body">
                        <div class="form-horizontal col-sm-10"  style="margin:10px 20px;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{$params['id']}}">
                            <input type="hidden" name="parent" value="{{ $data->parent}}">
                            <div class="form-group">
                                <label for="username" class="col-sm-3 control-label">用户名</label>
                                <div class="col-sm-8">
                                    <input type="text" name="username" class="form-control" value="{{$data->username}}" @if($data->is_system)readonly="readonly"@endif>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">密码</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password" class="form-control" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">角色</label>
                                <div class="col-sm-8">
                                    @foreach($roleList as $role)
                                        <label class="radio-inline">
                                            <input type="radio" name="role_id" value="{{$role->id}}" title="{{$role->name}}"
                                            @if(in_array($role->id,array_column($data->roles->toArray(),'id')))checked="checked"@endif
                                            @if($data->id == Auth::user()->id)disabled="disabled"@endif>{{$role->name}}
                                            @if($data->id == Auth::user()->id)<input type="hidden" name="role_id" value="{{$role->id}}">@endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">状态</label>
                                <div class="col-sm-8">
                                    {{\App\Enums\BasicEnum::enumSelect($data->status,false,'status')}}
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-xs-2 col-md-1 col-sm-offset-3">
                                    @can('manager.update')
                                    <button type="submit" class="btn btn-primary J_ajax_submit_btn">提交</button>
                                    @endcan
                                </div>
                                <div class="col-xs-2 col-md-1">
                                    <a href="{{url('admin/manager')}}" class="btn btn-default">取消</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection