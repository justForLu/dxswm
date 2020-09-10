@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>角色授权</legend>
    </fieldset>

    <div class="panel panel-default mt10">
        <div class="panel-heading bg-white">[ {{\App\Enums\ModuleEnum::getDesc($role->module)}} ]-[ {{$role->name}} ]</div>
        <div class="panel-body">
            <form class="layui-form J_ajaxForm mt20" action="{{url('admin/role/authority')}}" method="post" id="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="role_id" value="{{ $params['role_id'] }}">

                <table class="table table-bordered table-striped J_check_wrap main-auth-table">
                    <thead>
                        <tr>
                            <col width="20%"/>
                            <col width="80%"/>
                        </tr>
                        <tr>
                            <th>菜单名称</th>
                            <th>操作权限</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menuList as $menu)
                        <tr>
                            <td>{{$menu->name}}</td>
                            <td></td>
                        </tr>
                            @if($menu->children)
                                @foreach($menu->children as $menu1)
                                    <tr>
                                        <td style="padding-left: 35px;"><label class="{{$menu1->active}}"><input type="checkbox" name="menus[]" class="J_check_all" value="{{$menu1->id}}"
                                                           data-direction="x" data-checklist="J_check_{{$menu1->id}}" {{$menu1->checked}}>
                                                    <span class="layui-checkbox-name">{{$menu1->name}}</span></label></td>
                                        <td>
                                            <ul class="auth-ul">
                                                @foreach($menu1->permissions as $permission)
                                                    <li class="length3">
                                                        <label class="{{$permission->active}}"><input type="checkbox" name="permissions[]" class="J_check" value="{{$permission->id}}"
                                                                       data-xid="J_check_{{$menu1->id}}" {{$permission->checked}}>
                                                                <span class="layui-checkbox-name">{{$permission->name}}</span></label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="box-footer">
                    <div class="col-xs-2 col-md-1 col-sm-offset-3">
                        @can('role.authority')
                        <button type="submit" class="btn btn-primary J_ajax_submit_btn">提交</button>
                        @endcan
                    </div>
                    <div class="col-xs-2 col-md-1">
                        <a href="{{url('admin/role')}}" class="btn btn-default">取消</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection