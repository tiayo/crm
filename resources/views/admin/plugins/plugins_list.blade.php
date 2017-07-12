@extends('admin.layouts.admin')

@section('style')
    @parent
@endsection

@section('breadcrumb')
    <div class="row">
        <div class="col-md-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb panel">
                <li navValue="nav_1"><a href="/"><i class="fa fa-home"></i>主页</a></li>
                <li navValue="nav_1_1">插件列表</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>
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
               	插件列表
            </header>
            <div class="panel-body">

            	<table class="table table-striped table-hover">
		            <thead>
		                <tr>
		                    <th>ID</th>
		                    <th>名称</th>
		                    <th>别名</th>
                            <th>类型</th>
							<th>作者</th>
							<th>版本</th>
							<th>状态(点击切换)</th>
							<th>描述</th>
							<th>操作</th>
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
                                    前台模块
                                @elseif ($list['type'] == 2)
                                    后台模块
                                @endif
                            </th>
                            <th>{{$list['author']}}</th>
                            <th>{{$list['version']}}</th>
                            <th>
                                @if ($list['status'] == 1)
                                    <button class="btn btn-success btn-xs" type="button" onclick="location='{{ Route('plugin_status', ['plugin_id' => $list['plugin_id']]) }}'">启用中</button>
                                    @else
                                    <button class="btn btn-warning btn-xs" type="button" onclick="location='{{ Route('plugin_status', ['plugin_id' => $list['plugin_id']]) }}'">禁用</button>
                                @endif

                                @if ($list['index'] == 1)
                                    <button class="btn btn-success btn-xs" type="button" onclick="location='{{ Route('plugin_index', ['plugin_id' => $list['plugin_id']]) }}'">前台显示</button>
                                @else
                                    <button class="btn btn-warning btn-xs" type="button" onclick="location='{{ Route('plugin_index', ['plugin_id' => $list['plugin_id']]) }}'">前台不显示</button>
                                @endif

                                @if ($list['install'] == 1)
                                    <button class="btn btn-success btn-xs" type="button" onclick="location='{{ Route('plugin_uninstall', ['plugin_id' => $list['plugin_id']]) }}'">已安装</button>
                                @else
                                    <button class="btn btn-warning btn-xs" type="button" onclick="location='{{ Route('plugin_install', ['plugin_id' => $list['plugin_id']]) }}'">未安装</button>
                                @endif
                            </th>
                            <th>{{$list['description']}}</th>
                            <th>
                                {{--其他操作按钮--}}
                                <button class="btn btn-big btn-info" type="button" onclick="location='{{ plugin_index($list['plugin_id']) }}'">默认首页</button>
                                <button class="btn btn-big btn-info" type="button" onclick="location='{{ Route('admin_plugins_update_post', ['plugin_id' => $list['plugin_id']]) }}'">设置</button>

                                <div class="btn-group">
                                    <button data-toggle="dropdown" type="button" class="btn btn-success btn-big dropdown-toggle">
                                        删除插件<span class="caret"></span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="javascript:if(confirm('操作不可恢复，确实要删除吗?'))location='{{ Route('admin_plugins_delete', ['plugin_id' => $list['plugin_id'], 'type' => 'only']) }}'">不删除目录文件</a></li>
                                        <li class="divider"></li>
                                        <li><a href="javascript:if(confirm('操作不可恢复，确实要删除吗?'))location='{{ Route('admin_plugins_delete', ['plugin_id' => $list['plugin_id'], 'type' => 'all']) }}'">全部删除</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">取消</a></li>
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
