<form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/salesman')}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label"><span class="red">*</span>业务员姓名</label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="url" class="col-sm-3 control-label"><span class="red">*</span>手机号</label>
        <div class="col-sm-8">
            <input type="text" name="mobile" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="sort" class="col-sm-3 control-label"><span class="red">*</span>微信号</label>
        <div class="col-sm-8">
            <input type="text" name="weixin" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">状态</label>
        <div class="col-sm-8">
            {{\App\Enums\BasicEnum::enumSelect(\App\Enums\BasicEnum::ACTIVE,false,'status')}}
        </div>
    </div>
    <div class="form-group hide">
        @can('salesman.store')
        <button type="submit" class="J_ajax_submit_btn"></button>
        @endcan
    </div>
</form>

