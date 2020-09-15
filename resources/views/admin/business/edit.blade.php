@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>编辑店家</legend>
    </fieldset>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/business',array($data->id))}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">管理员账号</label>
                            <div class="col-sm-8 form-control-static">
                                {{$data->admin_name}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span class="red">*</span>店家名称</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" autocomplete="off" class="form-control" value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span class="red">*</span>店家手机号</label>
                            <div class="col-sm-8">
                                <input type="text" name="mobile" autocomplete="off" class="form-control" value="{{$data->mobile}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span class="red">*</span>店铺封面</label>
                            <div class="col-sm-8">
                                <div class="J_upload_image" data-id="image" data-_token="{{ csrf_token() }}">
                                    @if(!empty($data->image))
                                        <input type="hidden" name="image_val" value="{{ $data->image }}">
                                        <input type="hidden" name="image_path[]" value="{{ $data->image }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-8"><span class="tips">建议尺寸</span></div>
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
                            <label for="sort" class="col-sm-3 control-label"><span class="red">*</span>高校</label>
                            <div class="col-sm-8">
                                <select name="school" class="form-control">
                                    <option value="0">请选择高校</option>
                                    @if($school)
                                        @foreach($school as $val)
                                            <option value="{{$val['id']}}" @if($val['selected']) selected @endif>{{$val['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span class="red">*</span>经营时间范围</label>
                            <div class="col-sm-8">
                                <input type="text" name="time_limit" autocomplete="off" class="form-control" value="{{$data->time_limit}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">公告</label>
                            <div class="col-sm-8">
                                <textarea name="notice" class="form-control" cols="50" rows="5">{{$data->notice}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sort" class="col-sm-3 control-label">业务员</label>
                            @if($role_id == 1)
                                <div class="col-sm-8">
                                    <select name="salesman_id" class="form-control">
                                        <option value="0">请选择业务员</option>
                                        @if($salesman)
                                            @foreach($salesman as $v)
                                                <option value="{{$v['id']}}" @if($v['id'] == $data->id) selected @endif>{{$v['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            @else
                                <div class="col-sm-8 form-control-static">
                                    {{$data->salesman_name}}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">状态</label>
                            <div class="col-sm-8">
                                {{\App\Enums\BusinessEnum::enumSelect($data->status,false,'status')}}
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-xs-2 col-md-1 col-sm-offset-3">
                                @can('business.update')
                                    <button type="submit" class="btn btn-primary J_ajax_submit_btn">提交</button>
                                @endcan
                            </div>
                            <div class="col-xs-2 col-md-1">
                                <a href="{{url('admin/business')}}" class="btn btn-default">取消</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(".region").on('change', function () {
            var province = $("select[name='province']").val();
            var city = $("select[name='city']").val();
            var area = $("select[name='area']").val();

            $.get('/admin/get_school_list',{province:province,city:city,area:area} , function (obj) {
                if(obj.code == 200){
                    var schoolList = obj.data;
                    var html = "<option value='0'>请选择高校</option>";
                    $.each(schoolList, function (i, school) {
                        html += "<option value='"+school.id+"'>"+school.name+"</option>";
                    });
                    $("select[name='school']").html(html);
                }
            });
        });
    </script>
@endsection

