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
                添加菜单
            </header>
            <div class="panel-body">
                <form id="form" class="form-horizontal adminex-form" method="post" action="{{ $url }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*菜单名称</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" placeholder="" name="name" value="{{ $old_input['name'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*路由别名</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="" id="route" value="{{ $old_input['route'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*显示顺序</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="position" value="{{ $old_input['position'] or 0}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2">父级菜单</label>
                        <div class="col-lg-3">
                            <select class="form-control m-bot15" name="parent" id="parent_select">
                                @if (isset($old_input['parent']))
                                    <option value="{{ $old_input['parent'] }}">保持不变</option>
                                @endif
                                <option value="0">顶级菜单</option>

                                @foreach($all_sidebar as $sidebar)
                                        <option value="{{ $sidebar['sidebar_id'] }}">{{ $sidebar['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 col-sm-2 col-sm-2 control-label">*菜单显示</label>
                            <div class="col-sm-10 controls">
                                <label class="pull-left" style="margin-right: 1em">
                                <span class="checked">
                                    <div class="radio">
                                        <span class="checked">
                                            <input type="radio" value="1" name="index" @if(!isset($old_input['index']) || $old_input['index'] == 1) checked @endif>
                                            显示
                                        </span>
                                    </div>
                                </span>
                                </label>
                                <label class="pull-left">
                                <span>
                                    <div class="radio">
                                        <span class="">
                                            <input type="radio" value="0" name="index" @if(isset($old_input['index']) && $old_input['index'] == 0) checked @endif>
                                            不显示
                                        </span>
                                    </div>
                                </span>
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
    <script>
        $(document).ready(function () {

            routeSwitch();

            $('#parent_select').change(function () {
                routeSwitch();
            });

        });

        function routeSwitch() {
            var route = $('#route');

            if ($('#parent_select').val() == 0) {
                route.attr('name', '');
                route.removeAttr("required");
            } else {
                route.attr('name', 'route');
                route.attr("required", "true");
            }
        }
    </script>
@endsection
