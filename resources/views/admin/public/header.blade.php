<header class="main-header">

    <a href="/" class="logo">
        <img src="{{asset("/assets/admin/images/logo.png")}}">
    </a>
    <nav class="navbar navbar-static-top">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="user user-menu">
                    <a href="javascript:void(0);">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                        <span class="hidden-xs">{{Auth::user()->username}}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/admin/logout') }}"><i class="fa fa-sign-out"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>