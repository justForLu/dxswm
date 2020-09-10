<form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/menu')}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label class="col-sm-3 control-label">上级菜单</label>
        <div class="col-sm-8">
            <select name="parent" class="form-control">
                <option value="0">顶级菜单</option>
                @foreach($list as $menuLevel1)
                    <option value="{{$menuLevel1->id}}">{{$menuLevel1->name}}</option>
                    @foreach($menuLevel1->children as $menuLevel2)
                        <option value="{{$menuLevel2->id}}">&nbsp;&nbsp;&nbsp;{{$menuLevel2->name}}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">菜单名称</label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="url" class="col-sm-3 control-label">菜单地址</label>
        <div class="col-sm-8">
            <input type="text" name="url" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="sort" class="col-sm-3 control-label">菜单排序</label>
        <div class="col-sm-8">
            <input type="text" name="sort" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="code" class="col-sm-3 control-label">菜单编码</label>
        <div class="col-sm-8">
            <input type="text" name="code" class="form-control">
        </div>
    </div>
    <div class="form-group hide">
        @can('menu.store')
        <button type="submit" class="J_ajax_submit_btn"></button>
        @endcan
    </div>
</form>

