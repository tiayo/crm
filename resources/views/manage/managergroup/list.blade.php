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

    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        管理员分组列表
                        <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                        <a href="javascript:;" class="fa fa-times"></a>
                     </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table editable-table ">
                            <div class="clearfix">
                                <div class="btn-group">
                                    <button class="btn btn-primary" onclick="location='{{ route('managergroup_add') }}'">
                                        添加分组 <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div style="width: 100%;margin-bottom: 1em;"></div>
                            <div id="editable-sample_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <table class="table table-striped table-hover table-bordered dataTable" id="editable-sample" aria-describedby="editable-sample_info">
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <tr class="odd">
                                        <th class="  sorting_1">ID</th>
                                        <th class=" ">分组名</th>
                                        <th class=" ">分组规则</th>
                                        <th class="center ">更新时间</th>
                                        <th class=" ">操作</th>
                                    </tr>

                                    @foreach($all_group as $group)
                                    <tr class="even">
                                        <td>{{ $group['managergroup_id'] }}</td>
                                        <td>{{ $group['name'] }}</td>
                                        <td>{{ json_encode(unserialize($group['rule'])) }}</td>
                                        <td>{{ $group['updated_at'] }}</td>
                                        <td>
                                            <button class="btn btn-info" type="button" onclick="location='{{ route('managergroup_update', ['id' => $group['managergroup_id'] ]) }}'">编辑</button>
                                            删除
                                        </td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @parent
@endsection
