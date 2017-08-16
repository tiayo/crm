@extends('manage.layouts.manage')

@section('style')
    @parent
    <!--multi-select-->
    <link rel="stylesheet" type="text/css" href="/static/adminex/js/jquery-multi-select/css/multi-select.css" />
@endsection

@section('body')
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    添加/编辑分组
                    <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                                <a class="fa fa-times" href="javascript:;"></a>
                             </span>
                </header>

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

                <div class="panel-body">
                    <form action="{{ $url }}" class="form-horizontal" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-lg-3 col-sm-3 control-label">分组名称</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $old_input['name'] }}" placeholder="分组名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="parent_id" class="col-lg-3 col-sm-3 control-label">上级分组</label>
                            <div class="col-lg-3">
                                <select class="form-control m-bot15" name="parent_id" id="parent_id">
                                    @foreach($all_group as $group)
                                        <option value="{{ $group['managergroup_id'] }}">{{ $group['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @foreach($all_sidebar as $key => $sidebar)
                            <div class="form-group">
                                <label for="my_multi_select{{ $key + 1 }}" class="control-label col-md-3">{{ $sidebar['name'] }}</label>

                                <div class="col-md-9">
                                    <select multiple="multiple" class="multi-select" id="my_multi_select{{ $key + 1 }}"
                                            name="rule[]">

                                        @foreach($sidebar['childs'] as $num => $childs)
                                            <option value="{{ $childs['sidebar_id'] }}"
                                                @if(!empty($old_input['rule']) && in_array($childs['sidebar_id'], $old_input['rule'])) selected @endif>
                                                {{ $childs['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                            <button class="btn btn-info" type="submit">提交</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <!--multi-select-->
    <script type="text/javascript" src="/static/adminex/js/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="/static/adminex/js/jquery-multi-select/js/jquery.quicksearch.js"></script>
    <script src="/static/adminex/js/multi-select-init.js"></script>
@endsection
