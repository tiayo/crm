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
                添加/更新管理员
            </header>
            <div class="panel-body">
                <form id="form" class="form-horizontal adminex-form" method="post" action="{{ $url }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-sm-2 control-label">管理员帐号</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $old_input['name'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 col-sm-2 control-label">管理员邮箱</label>
                        <div class="col-sm-3">
                            <input type="email" class="form-control" id="email" name="email" value="{{ $old_input['email'] or null}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 col-sm-2 control-label">管理员密码</label>
                        <div class="col-sm-3">
                            <input type="password" class="form-control" id="password" name="" value="{{ $old_input['password'] or null}}" placeholder="不更改请放空">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="group" class="col-sm-2 control-label col-lg-2">分组</label>
                        <div class="col-lg-3">
                            <select class="form-control m-bot15" name="group" id="group">
                                @if (isset($old_input['group']))
                                    <option value="{{ $old_input['group'] }}">保持不变</option>
                                @endif

                                @foreach($all_group as $group)
                                        <option value="{{ $group['managergroup_id'] }}">{{ $group['name'] }}</option>
                                @endforeach
                            </select>
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
            $('#form').submit(function () {
                var password = $('#password');
                var length = password.val().length;

                if (length > 0) {
                    password.attr('name', 'password');
                }
            })
        })
    </script>
@endsection
