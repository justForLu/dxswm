<form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/permission')}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">权限名称</label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="code" class="col-sm-3 control-label">权限编码</label>
        <div class="col-sm-8">
            <input type="text" name="code" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">所属菜单</label>
        <div class="col-sm-8">
            <select name="menu_id" class="form-control">
                @foreach($list as $menuLevel1)
                    @if($menuLevel1->children)
                        <optgroup label="{{$menuLevel1->name}}">
                            @foreach($menuLevel1->children as $menuLevel2)
                                <option value="{{$menuLevel2->id}}">{{$menuLevel2->name}}</option>
                            @endforeach
                        </optgroup>
                    @else
                        <option value="{{$menuLevel1->id}}">{{$menuLevel1->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="desc" class="col-sm-3 control-label">权限描述</label>
        <div class="col-sm-8">
            <textarea name="desc" class="form-control"></textarea>
        </div>
    </div>
    <div class="form-group hide">
        @can('permission.store')
        <button type="submit" class="J_ajax_submit_btn"></button>
        @endcan
    </div>
</form>

