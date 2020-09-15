<form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/salesman',array($data->id))}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label class="col-sm-3 control-label"><span class="red">*</span>业务员姓名</label>
        <div class="col-sm-8">
            <input type="text" name="name" autocomplete="off" class="form-control length4" value="{{$data->name}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label"><span class="red">*</span>手机号</label>
        <div class="col-sm-8">
            <input type="text" name="mobile" autocomplete="off" class="form-control length4" value="{{$data->mobile}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label"><span class="red">*</span>微信号</label>
        <div class="col-sm-8">
            <input type="text" name="weixin" autocomplete="off" class="form-control length4" value="{{$data->weixin}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">状态</label>
        <div class="col-sm-8">
            {{\App\Enums\BasicEnum::enumSelect($data->status,false,'status')}}
        </div>
    </div>
    <div class="form-group hide">
        @can('salesman.update')
        <button type="submit" class="J_ajax_submit_btn"></button>
        @endcan
    </div>
</form>
