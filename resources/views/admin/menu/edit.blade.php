<form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/menu',array($data->id))}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label class="col-sm-3 control-label">上级菜单</label>
        <div class="col-sm-8">
        <select name="parent" class="form-control length4">
            <option value="0">顶级菜单</option>
            @foreach($list as $menuLevel1)
                <option value="{{$menuLevel1->id}}" @if($menuLevel1->id == $data->parent)selected="selected"@endif>{{$menuLevel1->name}}</option>
                @if(isset($menuLevel1->children))
                    @foreach($menuLevel1->children as $menuLevel2)
                        <option value="{{$menuLevel2->id}}" @if($menuLevel2->id == $data->parent)selected="selected"@endif>&nbsp;&nbsp;&nbsp;{{$menuLevel2->name}}</option>
                    @endforeach
                @endif
            @endforeach
        </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">菜单名称</label>
        <div class="col-sm-8">
            <input type="text" name="name" autocomplete="off" class="form-control length4" value="{{$data->name}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">菜单地址</label>
        <div class="col-sm-8">
            <input type="text" name="url" autocomplete="off" class="form-control length4" value="{{$data->url}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">菜单排序</label>
        <div class="col-sm-8">
            <input type="text" name="sort" autocomplete="off" class="form-control length4" value="{{$data->sort}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">菜单编码</label>
        <div class="col-sm-8">
            <input type="text" name="code" autocomplete="off" class="form-control length4" value="{{$data->code}}">
        </div>
    </div>
    <div class="form-group hide">
        @can('menu.update')
        <button type="submit" class="J_ajax_submit_btn"></button>
        @endcan
    </div>
</form>