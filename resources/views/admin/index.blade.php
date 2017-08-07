@extends('admin.layouts.admin')

@section('style')
    @parent
@endsection

@section('breadcrumb')
    <div class="row">
        <div class="col-md-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb panel">
                <li navValue=""><a href="/"><i class="fa fa-home"></i>系统管理员后台</a></li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>
@endsection

@section('body')
    <div class="col-md-12">
        欢迎您：{{ Auth::guard('admin')->user()->name }}，这里是系统管理员后台！
    </div>
@endsection

@section('script')
    @parent
@endsection
