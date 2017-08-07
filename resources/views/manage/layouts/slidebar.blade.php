<!--sidebar nav start-->
<ul style="margin-top:100px;" class="nav nav-pills nav-stacked custom-nav">
    @foreach($app->tree($app->allOutIndex())  as $value)
        <li class="menu-list" id="nav_{{ $value['sidebar_id'] }}"><a href=""><i class="fa fa-gears"></i> <span>{{ $value['name'] }}</span></a>
            <ul class="sub-menu-list">
                @if(isset($value['childs']) && !empty($value['childs']))
                    @foreach($value['childs'] as $item)
                        <li id="nav_{{ $item['sidebar_id'] or 0 }}"><a href="{{ route_defined($item['route']) }}">{{ $item['name'] }}</a></li>
                    @endforeach
                @endif
            </ul>
        </li>
    @endforeach

    <li class="menu-list" id="nav_0"><a href=""><i class="fa fa-border"></i> <span>菜单管理</span></a>
        <ul class="sub-menu-list">
            <li><a href="{{ Route('manage_sidebar_view') }}">管理菜单</a></li>
            <li><a href="{{ Route('manage_sidebar_add') }}">添加菜单</a></li>
        </ul>
    </li>

</ul>
<!--sidebar nav end-->