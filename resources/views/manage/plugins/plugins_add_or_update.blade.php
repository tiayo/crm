@extends('manage.layouts.manage')

@section('style')
    @parent
@endsection

@section('body')
    <div class="col-md-12">

        <!--错误输出-->
        <div class="form-group">
            <div class="alert alert-danger fade in @if(!count($errors) > 0) hidden @endif" id="alert_error">
                <a href="#" class="close" data-dismiss="alert">×</a>
                <span>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </span>
            </div>
        </div>

        <section class="panel">
            <header class="panel-heading">
                添加插件
            </header>
            <div class="panel-body">
                <form id="form" class="form-horizontal adminex-form" method="post" action="{{ $url }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 col-sm-2 col-sm-2 control-label">*类型</label>
                        @if($sign != 'update')
                        <div class="col-sm-10 controls">
                            <label class="pull-left" style="margin-right: 1em">
                                <span class="checked">
                                    <div class="radio">
                                        <span class="checked">
                                            <input type="radio" value="2" name="type" @if(empty($old_input['type']) || $old_input['type'] == 2) checked @endif>
                                            后台插件
                                        </span>
                                    </div>
                                </span>
                            </label>
                            <label class="pull-left">
                                <span>
                                    <div class="radio">
                                        <span class="">
                                            <input type="radio" value="1" name="type" @if($old_input['type'] == 1) checked @endif>
                                            前台插件
                                        </span>
                                    </div>
                                </span>
                            </label>
                        </div>
                        @elseif($sign == 'update')
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="type" value="@if($old_input['type'] == 1) 前台插件 @else 后台插件 @endif" readonly>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*名称</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" placeholder="" name="name" value="{{ $old_input['name'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*别名</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" placeholder="" name="alias" value="{{ $old_input['alias'] }}" @if($sign == 'update') readonly @endif required>
                        </div>
                        <div class="pull-left">
                            <span class="help-inline">（使用纯英文字母命名，遵循大驼峰命名，例如：ExamplePlugins）</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*版本</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="version" value="{{ $old_input['version'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*作者</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="author" value="{{ $old_input['author'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*描述</label>
                        <div class="col-sm-3">
                            <textarea row="3" class="form-control" name="description" required>{{ $old_input['description'] }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*启用</label>
                        <div class="col-sm-3">
                            <label class="checkbox">
                                <div class="checker"><span class="checked"><input type="checkbox" name="status" value="1" checked=""></span></div>
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-success" type="submit"><i class="fa fa-cloud-upload"></i> 提交创建</button>
                    </div>

                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    @parent
@endsection
