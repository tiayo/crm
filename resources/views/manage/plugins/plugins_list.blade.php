@extends('manage.layouts.manage')

@section('style')
    @parent
@endsection

@section('body')
<div class="row">
    <!--错误输出-->
    <div class="col-md-12 ">
        <div class="alert alert-danger fade in hidden" id="alert_error">
            <a href="#" class="close" data-dismiss="alert">×</a>
            <strong>Error!</strong> <span></span>
        </div>
    </div>

    <div class="col-md-12">
		<section class="panel">
            <header class="panel-heading">
               	{{ __("title.插件列表") }}
            </header>
            <div class="panel-body">

            	<table class="table table-striped table-hover">
		            <thead>
		                <tr>
		                    <th>ID</th>
		                    <th>{{ __("title.名称") }}</th>
		                    <th>{{ __("title.别名") }}</th>
                            <th>{{ __("title.类型") }}</th>
							<th>{{ __("title.作者") }}</th>
							<th>{{ __("title.版本") }}</th>
							<th>{{ __("title.状态(点击切换)") }}</th>
							<th>{{ __("title.描述") }}</th>
							<th>{{ __("title.操作") }}</th>
		                </tr>
		            </thead>

		            <tbody id="target">
                        @foreach($lists as $list)
                        <tr>
                            <th>{{$list['plugin_id']}}</th>
                            <th>{{$list['name']}}</th>
                            <th>{{$list['alias']}}</th>
                            <th>
                                @if ($list['type'] == 1)
                                    {{ __('sidebar.前台插件') }}
                                @elseif ($list['type'] == 2)
                                    {{ __('sidebar.后台插件') }}
                                @endif
                            </th>
                            <th>{{$list['author']}}</th>
                            <th>{{$list['version']}}</th>
                            <th>
                                @if ($list['status'] == 1)
                                    <button class="btn btn-success btn-xs" type="button" onclick="location='{{ Route('plugin_status', ['plugin_id' => $list['plugin_id']]) }}'">{{ __('title.启用中') }}</button>
                                    @else
                                    <button class="btn btn-warning btn-xs" type="button" onclick="location='{{ Route('plugin_status', ['plugin_id' => $list['plugin_id']]) }}'">{{ __('title.禁用') }}</button>
                                @endif

                                @if ($list['index'] == 1)
                                    <button class="btn btn-success btn-xs" type="button" onclick="location='{{ Route('plugin_index', ['plugin_id' => $list['plugin_id']]) }}'">{{ __('title.前台显示') }}</button>
                                @else
                                    <button class="btn btn-warning btn-xs" type="button" onclick="location='{{ Route('plugin_index', ['plugin_id' => $list['plugin_id']]) }}'">{{ __('title.前台不显示') }}</button>
                                @endif

                                @if ($list['install'] == 1)
                                    <button class="btn btn-success btn-xs" type="button" onclick="location='{{ Route('plugin_uninstall', ['plugin_id' => $list['plugin_id']]) }}'">{{ __('title.已安装') }}</button>
                                @else
                                    <button class="btn btn-warning btn-xs" type="button" onclick="location='{{ Route('plugin_install', ['plugin_id' => $list['plugin_id']]) }}'">{{ __('title.未安装') }}</button>
                                @endif
                            </th>
                            <th>{{$list['description']}}</th>
                            <th>
                                {{--其他操作按钮--}}
                                <button class="btn btn-big btn-info" type="button" onclick="window.open('{{ plugin_index($list['plugin_id']) }}')">{{ __('title.默认首页') }}</button>
                                <button class="btn btn-big btn-info" type="button" onclick="location='{{ Route('plugins_update', ['plugin_id' => $list['plugin_id']]) }}'">{{ __('title.设置') }}</button>

                                <div class="btn-group @if($list['plugin_id'] == 0) hidden @endif">
                                    <button data-toggle="dropdown" type="button" class="btn btn-success btn-big dropdown-toggle">
                                        {{ __('title.删除插件') }}<span class="caret"></span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="javascript:if(confirm('操作不可恢复，确实要删除吗?'))location='{{ Route('plugins_delete', ['plugin_id' => $list['plugin_id'], 'type' => 'only']) }}'">{{ __('title.不删除目录文件') }}</a></li>
                                        <li class="divider"></li>
                                        <li><a href="javascript:if(confirm('操作不可恢复，确实要删除吗?'))location='{{ Route('plugins_delete', ['plugin_id' => $list['plugin_id'], 'type' => 'all']) }}'">{{ __('title.全部删除') }}</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">{{ __('title.取消') }}</a></li>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
		        </table>
		        <div id="page"></div>
        	</div>
    	</section>
    </div>
</div>
@endsection

@section('script')
    @parent
@endsection
