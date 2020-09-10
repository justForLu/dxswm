@extends('admin.layout.login')

@section('content')
    <div class="login-logo"><img src="{{asset("/assets/admin/images/logo_main.png")}}"></div>
    <div class="login-form">
        <form class="J_ajaxForm" method="post" action="{{url('admin/login')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="login-item">
                <input type="text" name="username" placeholder="账号" value=""/>
            </div>
            <div class="login-item">
                <input type="password" name="password" placeholder="密码" value=""/>
            </div>
            <button type="submit" class="login-btn J_ajax_submit_btn">登录</button>
        </form>
    </div>
@endsection