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
		                    <th>名称</th>
		                    <th>邮箱</th>
							<th>操作</th>
		                </tr>
		            </thead>

		            <tbody id="target">
                        @foreach($managers as $manager)
                        <tr>
                            <th>{{$manager['id']}}</th>
                            <th>{{$manager['name']}}</th>
                            <th>{{$manager['email']}}</th>
                            <th>操作</th>
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
