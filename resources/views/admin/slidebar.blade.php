<!--sidebar nav start-->
<ul style="margin-top:100px;" class="nav nav-pills nav-stacked custom-nav">
    @foreach($app->tree($app->all())  as $value)
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
</ul>
<!--sidebar nav end-->