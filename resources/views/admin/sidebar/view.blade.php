@extends('admin.layouts.admin')

@section('style')
    @parent
@endsection

@section('breadcrumb')
    <div class="row">
        <div class="col-md-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb panel">
                <li navValue="nav_0"><a href="/"><i class="fa fa-home"></i>主页</a></li>
                <li navValue="nav_0_1">菜单管理</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>
@endsection

@section('body')
    <div class="row">
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
                            <th>父级</th>
                            <th>路由</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>

                        <tbody id="target">
                        @foreach($lists as $list)
                            <tr>
                                <th>{{ $list['sidebar_id'] }}</th>
                                <th style="@if($list['parent'] == 0) color:black @endif">{{ $list['name'] }}</th>
                                <th>{{ $list['parent_t'] }}</th>
                                <th>{{ $list['route'] }}</th>
                                <th>
                                    @if ($list['index'] == 1)
                                        显示中
                                    @elseif ($list['type'] == 2)
                                        未显示
                                    @endif
                                </th>
                                <th>
                                    <button class="btn btn-success btn-big" type="button" onclick="location=''">修改</button>
                                    <button class="btn btn-danger btn-big" type="button" onclick="location=''">删除</button>
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
