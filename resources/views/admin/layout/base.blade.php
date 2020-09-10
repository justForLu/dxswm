<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>欢迎登录拾叁商场系统</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    @include('admin.public.css')
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">
    @include('admin.public.header')

    @include('admin.public.sidebar')

    <div class="content-wrapper">
        @yield('content')
    </div>
</div>
@include('admin.public.js')
@yield('scripts')
</body>
</html>