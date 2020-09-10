@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>网站配置</legend>
    </fieldset>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/config',array($data->id))}}" method="post">
                    <div class="box-body">
                        <div class="form-horizontal col-sm-10"  style="margin:10px 20px;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <label for="title" class="col-sm-3 control-label">网站标题</label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" class="form-control" value="{{$data->title}}" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="copyright" class="col-sm-3 control-label">网站版权</label>
                                <div class="col-sm-8">
                                    <input type="text" name="copyright" class="form-control" value="{{$data->copyright}}" autocomplete="off">
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-xs-2 col-md-1 col-sm-offset-3">
                                    @can('config.update')
                                    <button type="submit" class="btn btn-primary J_ajax_submit_btn">提交</button>
                                    @endcan
                                </div>
                                <div class="col-xs-2 col-md-1">
                                    <a href="{{url('admin/config')}}" class="btn btn-default">取消</a>
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