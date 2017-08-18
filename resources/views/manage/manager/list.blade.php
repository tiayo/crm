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
               	管理员列表
            </header>
            <div class="panel-body">

            	<table class="table table-striped table-hover">
		            <thead>
		                <tr>
		                    <th>ID</th>
		                    <th>帐号</th>
		                    <th>邮箱</th>
                            <th>用户组</th>
							<th>操作</th>
		                </tr>
		            </thead>

		            <tbody id="target">
                        @foreach($managers as $manager)
                        <tr>
                            <td>{{ $manager['id'] }}</td>
                            <td>{{ $manager['name'] }}</td>
                            <td>{{ $manager['email'] }}</td>
                            <td>{{ $manager['group_name'] or ($manager['name'] == config('group_name') ? '超级管理员' : null) }}</td>
                            <td>
                                @if (Auth::guard('manager')->user()['name'] !== $manager['name'])
                                    <button class="btn btn-info" type="button" onclick="location='{{ route('manager_update', ['id' => $manager['id'] ]) }}'">编辑</button>
                                    <button class="btn btn-info" type="button" onclick="javascript:if(confirm('操作不可恢复，确实要删除吗?'))location='{{ route('manager_destroy', ['id' => $manager['id'] ]) }}'">删除</button>
                                @else
                                    禁止操作
                                @endif
                            </td>
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
