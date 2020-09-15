@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>编辑高校</legend>
    </fieldset>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/school',array($data->id))}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span class="red">*</span>高校名称</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" autocomplete="off" class="form-control" value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span class="red">*</span>行政区划</label>

                            <input type="hidden" id="city_id" name="city_id" value="{{ $data->city_id }}">
                            <div class="col-sm-2">
                                <select name="province" data-url="{{url('admin/get_city_list')}}" data-init="true"
                                        data-value="{{isset($data->city['province']) ? $data->city['province'] : ''}}" data-target="subCity" data-val="city_id" class="form-control J_ajax_select">
                                    <option>请选择</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="city" data-val="city" id="subCity" data-url="{{url('admin/get_city_list')}}"
                                        data-value="{{isset($data->city['city']) ? $data->city['city'] : ''}}"  data-target="subDistinct"  class="form-control J_ajax_select">
                                    <option>请选择</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="area" data-val="city_id" id="subDistinct" data-url="{{url('admin/get_city_list')}}"
                                        data-value="{{isset($data->city['area']) ? $data->city['area'] : ''}}" data-target="thrCity" class="form-control J_ajax_select">
                                    <option>请选择</option>
                                </select>
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
                                @can('school.update')
                                    <button type="submit" class="btn btn-primary J_ajax_submit_btn">提交</button>
                                @endcan
                            </div>
                            <div class="col-xs-2 col-md-1">
                                <a href="{{url('admin/school')}}" class="btn btn-default">取消</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

