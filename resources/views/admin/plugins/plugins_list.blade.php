@extends('admin.layouts.admin')

@section('style')
    @parent
    <link href="/Manage/media/css/style.css" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <div class="row">
        <div class="col-md-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb panel">
                <li><a href="/"><i class="fa fa-home"></i>主页</a></li>
                <li class="active">插件列表</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>
@endsection

@section('body')
<!--搜索中弹窗-->
<div class="float hidden">
    <h4 class="text-center">正在为您搜索...</h4>
    <div class="bs-example m-callback">
        <div class="style-content">
            <img src="/Manage/media/image/timg.gif">
        </div>
        <p><span class="label label-warning" id="m-callback-update">您需要耐心等待一会,不要刷新页面！</span></p>
    </div>
</div>

<div class="row">
    <!--错误输出-->
    <div class="col-md-12 ">
        <div class="alert alert-danger fade in hidden" id="alert_error">
            <a href="#" class="close" data-dismiss="alert">×</a>
            <strong>Error!</strong> <span></span>
        </div>
    </div>

		<section class="panel">
            <header class="panel-heading">
               	后台插件列表
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
							<th>状态</th>
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
                            <th>{{$list['edition']}}</th>
                            <th>
                                @if ($list['status'] == 1)
                                    启用中
                                    @else
                                    禁用
                                @endif
                            </th>
                            <th>{{$list['description']}}</th>
                            <th>

                                @if ($list['status'] == 1)
                                    <button class="btn btn-danger" type="button" onclick="location='{{ Route('plugin_status', ['plugin_id' => $list['plugin_id']]) }}'">关闭</button>
                                    @else
                                    <button class="btn btn-success" type="button" onclick="location='{{ Route('plugin_status', ['plugin_id' => $list['plugin_id']]) }}'">启用</button>
                                @endif
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
		        </table>
		        <div id="page"></div>
        	</div>
    	</section>

	</div>
@endsection

@section('script')
    @parent
@endsection
