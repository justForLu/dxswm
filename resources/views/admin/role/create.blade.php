<form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form"  action="{{url('admin/role')}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="parent" value="{{$role_id}}">
    <input type="hidden" name="module" value="{{$params['module']}}">

    <div class="form-group">
        <label class="col-sm-3 control-label">角色名称</label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control length4"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">角色描述</label>
        <div class="col-sm-8">
            <textarea name="desc" class="form-control length4"></textarea>
        </div>
    </div>
    <div class="form-group hide">
        @can('role.store')
        <button type="submit" class="J_ajax_submit_btn"></button>
        @endcan
    </div>
</form>
