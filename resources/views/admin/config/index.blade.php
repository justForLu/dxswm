@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>网站配置</legend>
    </fieldset>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="form-horizontal col-sm-10"  style="margin:10px 20px;">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">网站标题</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->title}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">网站版权</label>
                                <div class="col-sm-8 form-control-static">
                                    {{$data->copyright}}
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-xs-2 col-md-1 col-sm-offset-3">
                                    @can('config.edit')
                                        <a href="config/{{$data->id}}/edit" class="btn btn-primary">编辑</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection