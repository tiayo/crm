<!--sidebar nav start-->
<ul style="margin-top:100px;" class="nav nav-pills nav-stacked custom-nav">
    @foreach($app->tree($app->allOutIndex())  as $value)
        @if(isset($value['childs']) && !empty($value['childs']))
        <li class="menu-list" id="nav_{{ $value['sidebar_id'] }}"><a href=""><i class="fa fa-gears"></i> <span>{{ __("sidebar.".$value['name']) }}</span></a>
            <ul class="sub-menu-list">
                @foreach($value['childs'] as $item)
                    <li id="nav_{{ $item['sidebar_id'] or 0 }}">
                        <a href="{{ route_defined($item['route']) }}">
                            {{ __("sidebar.".$item['name']) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        @endif
    @endforeach

    @if (Auth::guard('manager')->user()['name'] == config('site.manage'))
        <li class="menu-list" id="nav_0"><a href=""><i class="fa fa-border"></i> <span>{{ __("sidebar.菜单管理") }}</span></a>
            <ul class="sub-menu-list">
                <li><a href="{{ Route('manage_sidebar_view') }}">{{ __("sidebar.管理菜单") }}</a></li>
                <li><a href="{{ Route('manage_sidebar_add') }}">{{ __("sidebar.添加菜单") }}</a></li>
            </ul>
        </li>
    @endif

</ul>
<!--sidebar nav end-->