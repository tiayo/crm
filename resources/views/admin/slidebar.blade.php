<!--sidebar nav start-->
<ul style="margin-top:100px;" class="nav nav-pills nav-stacked custom-nav">
    @foreach($app->tree($app->all())  as $value)
        <li class="menu-list" id="nav_1"><a href=""><i class="fa fa-gears"></i> <span>{{ $value['name'] }}</span></a>
            <ul class="sub-menu-list">
                @foreach($value['childs'] as $item)
                <li id="nav_{{ $item['sidebar_id'] }}"><a href="{{ Route($item['route']) }}">{{ $item['name'] }}</a></li>
                @endforeach
            </ul>
        </li>
    @endforeach

    <li class="menu-list" id="nav_0"><a href=""><i class="fa fa-border"></i> <span>菜单管理</span></a>
        <ul class="sub-menu-list">
            <li id="nav_0_1"><a href="{{ Route('admin_sidebar_view') }}">管理菜单</a></li>
            <li id="nav_0_2"><a href="{{ Route('admin_sidebar_add') }}">添加菜单</a></li>
        </ul>
    </li>

</ul>
<!--sidebar nav end-->