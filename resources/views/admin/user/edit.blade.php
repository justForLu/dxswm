@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>编辑用户</legend>
    </fieldset>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/user',array($data->id))}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">昵称</label>
                            <div class="col-sm-8 form-control-static">
                                {{$data->nickname}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">头像</label>
                            <div class="col-sm-8 form-control-static">
                                <img src="{{$data->avatar}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">性别</label>
                            <div class="col-sm-8 form-control-static">
                                {{\App\Enums\GenderEnum::getDesc($data->gender)}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">手机号</label>
                            <div class="col-sm-8 form-control-static">
                                {{$data->mobile}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">上次登录时间</label>
                            <div class="col-sm-8 form-control-static">
                                {{$data->login_time}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">上次登录IP</label>
                            <div class="col-sm-8 form-control-static">
                                {{$data->login_ip}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">是否商家</label>
                            <div class="col-sm-8 form-control-static">
                                {{\App\Enums\BoolEnum::getDesc($data->is_business)}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">是否骑手</label>
                            <div class="col-sm-8 form-control-static">
                                {{\App\Enums\BoolEnum::getDesc($data->is_rider)}}
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
                                @can('user.update')
                                    <button type="submit" class="btn btn-primary J_ajax_submit_btn">提交</button>
                                @endcan
                            </div>
                            <div class="col-xs-2 col-md-1">
                                <a href="{{url('admin/user')}}" class="btn btn-default">取消</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


