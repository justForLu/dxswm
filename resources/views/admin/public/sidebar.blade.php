<aside class="main-sidebar">

    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="active"><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i><span>控制台</span></a></li>

            @if(isset($userMenus))
                @foreach($userMenus as $menu1)
                    <li @if(isset($menu1->active))class="treeview active"@else class="treeview"@endif>
                        <a @if(!isset($menu1->children))href="{{$menu1->url}}"@else href="javascript:void(0);"@endif><i class="fa fa-files-o"></i><span>{{$menu1->name}}</span><i class="fa fa-angle-left pull-right"></i></a>
                        @if(isset($menu1->children))
                            <ul class="treeview-menu">
                                @foreach($menu1->children as $menu2)
                                    <li @if(isset($menu2->active))class="active"@endif>
                                        <a href="/admin{{$menu2->url}}"><i class="fa fa-circle-o"></i>{{$menu2->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endif
        </ul>
    </section>
</aside>