@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>查看反馈</legend>
    </fieldset>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/feedback',array($data->id))}}" method="post">
                    <div class="box-body">
                        <div class="form-horizontal col-sm-10"  style="margin:10px 20px;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">姓名</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->name}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">手机号</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->mobile}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">邮箱</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->email}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">反馈内容</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->content}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">状态</label>
                                <div class="col-sm-2">
                                    {{\App\Enums\FeedbackEnum::enumSelect($data->status,false,'status')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">备注</label>
                                <div class="col-sm-8">
                                    <textarea name="remark" cols="40" rows="5">
                                        {{$data->remark}}
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">操作管理员</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->admin_name}}
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-xs-2 col-md-1 col-sm-offset-3">
                                    @can('feedback.update')
                                    <button type="submit" class="btn btn-primary J_ajax_submit_btn">提交</button>
                                    @endcan
                                </div>
                                <div class="col-xs-2 col-md-1">
                                    <a href="{{url('admin/feedback')}}" class="btn btn-default">取消</a>
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