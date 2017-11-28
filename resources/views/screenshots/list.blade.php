@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')
	<link rel="stylesheet" href="{{base_path('public/bower_components/AdminLTEbootstrap/css/bootstrap.min.css')}}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="{{base_path('public/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{base_path('public/bower_components/AdminLTE/dist/css/AdminLTE.min.css')}}">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{base_path('public/bower_components/AdminLTE/dist/css/skins/_all-skins.min.css')}}">


	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Hover Data Table</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="lista-permissoes" class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>Ação</th>
								<th>Nome</th>
								<th>Descrição</th>
							</tr>
							</thead>
							<tbody>


							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- jQuery 2.2.3 -->
	<script src="{{base_path('public/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="{{base_path('public/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
	<!-- DataTables -->
	<script src="{{base_path('public/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{base_path('public/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
	<!-- SlimScroll -->
	<script src="{{base_path('public/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
	<!-- FastClick -->
	<script src="{{base_path('public/bower_components/AdminLTE/plugins/fastclick/fastclick.js')}}"></script>
	<!-- AdminLTE App -->
	<script src="{{base_path('public/bower_components/AdminLTE/dist/js/app.min.js')}}"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="{{base_path('public/bower_components/AdminLTE/dist/js/demo.js')}}"></script>
	<!-- page script -->
	<script>

	</script>
@endsection
