@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')

		<div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <section class="content-header">
                    <ol class="breadcrumb">
                        <li><a href="#" style=" color: #455560">Retail</a></li>
                        <li><a href="#" style=" color: #455560">Samsung</a></li>
                        <li><a href="#" style=" color: #455560">Reports</a></li>
                        <li class="active">Share of Shelf</li>
                    </ol>
                </section>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label>Country:</label>
                    <select  class="form-control select2" style="width: 100%; margin-top: 12px;" name="pais_id">
                        @foreach($paises as $value):
                            <option value="{{$value->id}}">{{$value->pais}}</option>
                        @endforeach
                    </select>
                    <!-- /.form-group -->
                </div>
            </div>

            <!-- /.col -->
            <div class="col-md-3">
                <!-- /.form-group -->
                <div class="form-group">
                    <div class="input-group" style="width: 100%; margin-top: 25px;">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control pull-right" name="data" id="reservation" type="text">
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-1">
                <!-- /.form-group -->
                <div class="form-group">
                    <div class="input-group btn-block" style="margin-top: 25px;">
                        <button type="submit" class="btn btn-default btn-block" value="submit">OK</button>
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.col -->
            
			<div class="clearfix visible-sm-block"></div>

			<div class="col-md-12">	
			   <div class="box box-solid" style="text-align:center; background-color:#dee4ea; margin-bottom:0;">
				<div class="box-body">				
					<div class="btn-group">
					  <span class="btn btn-default dropdown-toggle" data-jq-dropdown="#dropdown-retailers" data-toggle="dropdown">
						All Retailers <span class="caret"></span>
					  </span>
					</div>
					
					<div class="btn-group">
					  <span class="btn btn-default dropdown-toggle" data-jq-dropdown="#dropdown-categories" data-toggle="dropdown">
						All Categories <span class="caret"></span>
					  </span>
					</div>
				</div>
				<!-- /.box-body -->
			  </div>
			</div>	
			
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->	
		
        <!-- Main content -->
        <section class="content">

            <div class="clearfix visible-sm-block"></div>
			
			<div class="row">				
			<div class="col-md-4">	
				<div class="box box-default">
					<div class="box-header">
					  <h3 class="box-title">Share of Shelf</h3>
					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					  <div class="row">
						<div class="col-md-12">
						  <div class="chart-responsive text-center">
							<h1>19.9%</h1>
							  <div class="row">
								<div class="col-sm-6 col-xs-6">
								  <div class="description-block border-right">
									<span class="description-text">EVOLUTION</span><br />
									<span class="description-percentage text-green"><i class="fa fa-angle-up"></i> 17 p.p.</span><br />
									<small>Since 09/18/2017</small>
								  </div>
								  <!-- /.description-block -->
								</div>
								<!-- /.col -->
								<div class="col-sm-6 col-xs-6">
								  <div class="description-block">
									<span class="description-text">HISTORIC</span>&nbsp;&nbsp;<span class="description-percentage text-red"><i class="fa fa-angle-down"></i> 9 p.p.</span><br />
									<span class="sparkline-1"></span><br />
									<small>Since 08/21/2017</small>
								  </div>
								  <!-- /.description-block -->
								</div>
							  </div>
						  </div>
						  <!-- ./chart-responsive -->
						</div>
						<!-- /.col -->
					  </div>
					  <!-- /.row -->
					</div>
					<!-- /.box-body -->
					<div class="box-footer text-center">
					  <a href="javascript:void(0)" class="uppercase" style="display:block;">more details</a>
					</div>
					<!-- /.box-footer -->				
				  </div>
				  <!-- /.box -->
			</div>	  
		  
			<div class="col-md-8">	
				<div class="box box-default">
					<div class="box-header">
					  <h3 class="box-title">Competitors Share</h3>
					  <div class="box-tools pull-right">				  
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					  <div class="row">
						<div class="col-md-12">
						  <div class="chart-responsive" id="container_searchcoverage2">
						  </div>
						  <!-- ./chart-responsive -->
						</div>
						<!-- /.col -->
						<!-- /.col -->
					  </div>
					  <!-- /.row -->
					</div>
					<!-- /.box-body -->
				  </div>
				  <!-- /.box -->
			</div>
			
			<div class="clearfix visible-sm-block"></div>
		
			<div class="col-md-12">	
				<div class="box box-default">
					<div class="box-header">
					  <h3 class="box-title">Share by Product</h3>
					  <div class="box-tools pull-right">				  
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div>
					<!-- /.box-header -->
					<div class="box-body no-padding">				
					<table id="products" class="table table-hover no-margin">
						<thead>
							<tr>
							  <th style="width: 80px; min-width: 70px; max-width: 90px;"></th>
							  <th>Product</th>
							  <th>Brand</th>
							  <th style="width: 80px; min-width: 70px; max-width: 80px;">Share</th>
							</tr>
						</thead>
						<tbody>
							<tr>
							  <td><img src="../img/temp/samsung-s8.jpg" class="img-popover" height="50" /></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">Samsung Galaxy S8 Preto <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">Samsung <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; background-color:#e1ecb3;"><span class="badge bg-green pull-right" style="font-size:20px;">89%</span></td>
							</tr>
							<tr>
							  <td><img src="../img/temp/iphone7.jpg" class="img-popover" height="50" /></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0" style="display:block;">iPhone 7 32GB <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">Apple <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; background-color:#f0f1b4;"><span class="badge bg-green pull-right" style="font-size:20px;">83%</span></td>
							</tr>
							<tr>
							  <td><img src="../img/temp/Motorola-Moto-Z.jpg" class="img-popover" height="50" /></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0" style="display:block;">Smartphone Motorola Moto Z Style 64GB <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">Motorola <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; background-color:#fff5b5;"><span class="badge bg-yellow pull-right" style="font-size:20px;">71%</span></td>
							</tr>
							<tr>
							  <td><img src="../img/temp/Samsung-QLED-Smart-TV-65.jpg" class="img-popover" height="50" /></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0" style="display:block;">Samsung QLED Smart TV 65” Q8C 4K <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">Samsung <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; background-color:#fff1b2;"><span class="badge bg-yellow pull-right" style="font-size:20px;">63%</span></td>
							</tr>
							<tr>
							  <td><img src="../img/temp/Refrigerador-Consul-CRM35NK.jpg" class="img-popover" height="50" /></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0" style="display:block;">Refrigerador Consul CRM35NK Slim Frost Free <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">Consul <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; background-color:#ffecb0;"><span class="badge bg-yellow pull-right" style="font-size:20px;">51%</span></td>
							</tr>
							<tr>
							  <td><img src="../img/temp/samsung-J5.jpg" class="img-popover" height="50" /></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0" style="display:block;">Samsung Galaxy J5 <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">Samsung <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; background-color:#ffe8ad;"><span class="badge bg-yellow pull-right" style="font-size:20px;">46%</span></td>
							</tr>
							<tr>
							  <td><img src="../img/temp/Refrigerador-Electrolux-Frost-Free-Duplex-427L.jpg" class="img-popover" height="50" /></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0" style="display:block;">Refrigerador Electrolux Frost Free Duplex 427L <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">Electrolux <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; background-color:#f9cba7;"><span class="badge bg-red pull-right" style="font-size:20px;">32%</span></td>
							</tr>
							<tr>
							  <td><img src="../img/temp/iphone6-plus.jpg" class="img-popover" height="50" /></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0" style="display:block;">iPhone 6 Plus <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">Apple <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; background-color:#fdd3a4;"><span class="badge bg-red pull-right" style="font-size:20px;">34%</span></td>
							</tr>
							<tr>
							  <td><img src="../img/temp/Lavadora-de-Roupas-Brastemp-BWK11AB-11Kg.jpg" class="img-popover" height="50" /></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0" style="display:block;">Lavadora de Roupas Brastemp BWK11AB 11Kg Branca <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">Brastemp <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; background-color:#f6c7a8;"><span class="badge bg-red pull-right" style="font-size:20px;">15%</span></td>
							</tr>
							<tr>
							  <td><img src="../img/temp/LG-Q6-Dual-Chip-Android 7.0.jpg" class="img-popover" height="50" /></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0" style="display:block;">Smartphone LG Q6+ Dual Chip Android 7.0 <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; font-size:16px; word-wrap:break-word; white-space:normal;"><a href="javascript:void0">LG <img src="https://iprospectmonitor.com.br/images/chart_kw_icon.png"></a></td>
							  <td style="vertical-align:middle; background-color:#f2bfaa;"><span class="badge bg-red pull-right" style="font-size:20px;">7%</span></td>
							</tr>
						</tbody>
					</table>						
					<!-- /.table-responsive -->				  
					</div>
					<!-- /.box-body -->
				  </div>
				  <!-- /.box -->
			</div>
			
			<div class="clearfix visible-sm-block"></div>

			<div class="col-md-12">	
				<div class="box box-default">
					<div class="box-header">
					  <h3 class="box-title">Analysis & Insights</h3>
					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					  <div class="row">
						<div class="col-md-12">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut tempor, dui vitae mattis lacinia, est nibh tristique lorem, auctor tristique risus tellus ut nisl.</p>
							<ul>
								<li>Etiam maximus ligula risus, ut varius turpis aliquet vel.</li>
								<li>Mauris placerat pulvinar lectus, vel condimentum massa tempor sed.</li>
								<li>Nulla in lectus porta leo fringilla pellentesque.</li>
								<li>Phasellus sagittis lectus id leo elementum luctus.</li>
								<li>Integer malesuada id leo quis tristique.</li>
								<li>Nullam hendrerit purus vel augue condimentum, et vehicula eros imperdiet.</li>
							</ul>
							<p>Integer a faucibus nibh, ut consequat lorem. Nulla quis tellus gravida, vestibulum elit ut, faucibus mi. Donec pellentesque mi nibh, sit amet dictum sapien maximus bibendum. Sed eu volutpat nibh, eu cursus lacus. Nam at diam sed magna laoreet consequat vel at nulla. Donec nisl ligula, gravida sit amet nunc a, cursus tincidunt mi.</p>

						</div>
						<!-- /.col -->
					  </div>
					  <!-- /.row -->
					</div>
					<!-- /.box-body -->				
				  </div>
				  <!-- /.box -->
			</div>

			<div class="clearfix visible-sm-block"></div>
			
		  </div>
				
		</section>
		<!-- /.content -->
	  
@section('pagescript')
    <script src="{{ asset('/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/jquery-ui/jquery-ui.min.js') }}"></script>	
    <script src="{{ asset('/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/plugins/select2.full.min.js')}}"></script>
    <script src="{{ asset('/plugins/inputmask/dist/inputmask/inputmask.js')}}"></script>
    <script src="{{ asset('/plugins/inputmask/dist/inputmask/inputmask.date.extensions.js')}}"></script>
    <script src="{{ asset('/plugins/inputmask/dist/inputmask/inputmask.extensions.js')}}"></script>
    <script src="{{ asset('/plugins/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('/plugins/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ asset('/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ asset('/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{ asset('/js/pages/dashboard.js')}}"></script>
    <script src="{{ asset('/js/demo.js')}}"></script>
    <script src="{{ asset('/plugins/highcharts/highcharts.js')}}"></script>
    <script src="{{ asset('/plugins/highcharts/modules/exporting.js')}}"></script>
    <script src="{{ asset('/jquery-knob/js/jquery.knob.js')}}"></script>
    <script src="{{ asset('/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
    <!-- Dropdown -->
    <script src="{{ asset('/plugins/jquery-dropdown/jquery.dropdown.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
	jQuery(function () {
		//Select2 Elements
		jQuery('.countries').select2()

		//Date range picker
		jQuery('#period').daterangepicker()
		//Date range picker with time picker
		jQuery('#periodtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
		//Date range as a button
		jQuery('#daterange-btn').daterangepicker(
		  {
			ranges   : {
			  'Today'       : [moment(), moment()],
			  'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			  'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
			  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			  'This Month'  : [moment().startOf('month'), moment().endOf('month')],
			  'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			startDate: moment().subtract(29, 'days'),
			endDate  : moment()
		  },
		  function (start, end) {
			jQuery('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
		  }
		)

		//Date picker
		jQuery('#datepicker').datepicker({
		  autoclose: true
		})	
		
//http://interactive.l2inc.com/share-of-shelf/home-care-2017/
		var chart = new Highcharts.Chart({        
			chart: {
				renderTo: 'container_searchcoverage2',
				type: 'scatter',
				height: 300,
			},
			credits: {
				enabled: false
			},    
		title: {
			text: ''
		},
		xAxis: {
				type: 'datetime',
				style: {
					fontSize: '11px',
					fontFamily: 'Arial,sans-serif'
				},
				labels: {
					//rotation: -35,
				},
				dateTimeLabelFormats: {
					month: '%d/%m/%Y',
					year: '%Y'
				},
		  //alternateGridColor: '#F9F9F9'
		},
		yAxis: {
			title: {
				text: 'Share of Shelf (%)'
			}
		},
		legend: {
		  layout: 'vertical',
		  align: 'right',
		  verticalAlign: 'top',
		  margin: 50,
		  padding: 12,
		  itemMarginTop: 6,
		  itemMarginBottom: 6,
		  backgroundColor:'#F9F9F9'
		},
		plotOptions: {
			scatter: {
				marker: {
					radius: 5,
					states: {
						hover: {
							enabled: true,
						}
					}
				},
				states: {
					hover: {
						marker: {
							enabled: false
						},
						halo: {
							size: 30,
							opacity: 0.20,
						}                    
					}
				}
			}
		},
		tooltip: {    
		  shared: true,
		  useHTML: true,
		  pointFormat: '<span style="color: {series.color}">{series.name}</span>: <b>{point.y}%</b><br/>',							
		  borderRadius: 0,
		  xDateFormat: '%d/%m/%Y',
		  crosshairs: true,
		},    
			series: [{
					marker: {
						enabled: true,
						symbol: 'circle',
						radius: 15,
					},
					name: 'Samsung',
					legendIndex: 5,
					legendOrder: 5,
					//color: '#0070c0',
					color: 'rgba(0, 112, 192, 0.6)',    
					symbolHeight: 30,
					symbolWidth: 30,
					symbolPadding: 0,        
					data: [
						[Date.UTC(2017,8,1),28],
						[Date.UTC(2017,8,8),26.5],
						[Date.UTC(2017,8,15),24.9],
						[Date.UTC(2017,8,22),20.4],
						[Date.UTC(2017,8,29),19.9],
						]
					},{
					marker: {
						enabled: true,
						symbol: 'circle',
						radius: 15,
					},
					name: 'Motorola',
					legendIndex: 6,
					legendOrder: 6,
					//color: '#e26405',
					color: 'rgba(226, 100, 5, 0.6)',        
					symbolHeight: 3,
					symbolWidth: 3,
					symbolPadding: 0,
					data: [
						[Date.UTC(2017,8,1),10],
						[Date.UTC(2017,8,8),10],
						[Date.UTC(2017,8,15),11],
						[Date.UTC(2017,8,22),11],
						[Date.UTC(2017,8,29),10],
						]
					},{
					marker: {
						enabled: true,
						symbol: 'circle',
						radius: 15,
					},
					name: 'Brastemp',
					legendIndex: 5,
					legendOrder: 5,
					//color: '#792e9d',
					color: 'rgba(121, 46, 157, 0.6)',
					symbolHeight: 3,
					symbolWidth: 3,
					symbolPadding: 0,
					data: [
						[Date.UTC(2017,8,1),15.6],
						[Date.UTC(2017,8,8),15.6],
						[Date.UTC(2017,8,15),15.1],
						[Date.UTC(2017,8,22),16.2],
						[Date.UTC(2017,8,29),13.4],
						],
					},{
					marker: {
						enabled: true,
						symbol: 'circle',
						radius: 15,
						fillOpacity:0.3
					},
					name: 'Apple',
					legendIndex: 2,
					legendOrder: 2,
					color: '#777574',
					color: 'rgba(119, 117, 116, 0.6)',        
					symbolHeight: 3,
					symbolWidth: 3,
					symbolPadding: 0,
					data: [
						[Date.UTC(2017,8,1),52],
						[Date.UTC(2017,8,8),57.5],
						[Date.UTC(2017,8,15),54.4],
						[Date.UTC(2017,8,22),57.2],
						[Date.UTC(2017,8,29),53.1],
						]
					},{
					marker: {
						enabled: true,
						symbol: 'circle',
						radius: 15,
					},
					name: 'Sony',
					legendIndex: 4,
					legendOrder: 4,
					//color: '#00b05c',
					color: 'rgba(0, 176, 92, 0.6)',
					symbolHeight: 3,
					symbolWidth: 3,
					symbolPadding: 0,
					data: [
						[Date.UTC(2017,8,1),24.4],
						[Date.UTC(2017,8,8),24.4],
						[Date.UTC(2017,8,15),27.4],
						[Date.UTC(2017,8,22),26.6],
						[Date.UTC(2017,8,29),24.2],
						]
					},{
					marker: {
						enabled: true,
						symbol: 'circle',
						radius: 15,
					},
					name: 'LG',
					legendIndex: 3,
					legendOrder: 3,
					//color: '#ff0000',
					color: 'rgba(255, 0, 0, 0.6)',        
					symbolHeight: 3,
					symbolWidth: 3,
					symbolPadding: 0,
					data: [
						[Date.UTC(2017,8,1),56.4],
						[Date.UTC(2017,8,8),51.4],
						[Date.UTC(2017,8,15),42],
						[Date.UTC(2017,8,22),49.4],
						[Date.UTC(2017,8,29),48.8],
						]
					},{
					marker: {
						enabled: true,
						symbol: 'circle',
						radius: 15,
					},
					name: 'Electrolux',
					legendIndex: 7,
					legendOrder: 7,
					//color: '#eabb19',
					color: 'rgba(234, 187, 25, 0.6)',          
					symbolHeight: 3,
					symbolWidth: 3,
					symbolPadding: 0,
					data: [
						[Date.UTC(2017,8,1),5],
						[Date.UTC(2017,8,8),5.3],
						[Date.UTC(2017,8,15),4],
						[Date.UTC(2017,8,22),5.1],
						[Date.UTC(2017,8,29),5.2],
						]
			},
			]
		});
		
		//SPARKLINE CHARTS
		jQuery(".sparkline-1").sparkline([14.2, 6.5, 17.2, 23.2, 29.8, 14.6], {
			type: 'line',
			width: '60',
			height: '17',
			lineColor: '#4c5962',
			highlightLineColor: '#4c5962',
			fillColor: '#ffffff',
			spotColor: '#404B53',
			highlightSpotColor: '#404B53',
			minSpotColor: '#ff0000',
			maxSpotColor: '#5fbf00',
			spotRadius: 2,
			tooltipSuffix: '%',
			normalRangeMin: 0,
			normalRangeMax: 100,
			normalRangeColor: '#ffffff'
		});			
		
		$('#products').DataTable({
		  'iDisplayLength'	: 100,
		  'aLengthMenu'		: [[20, 50, 100, 200, 500, -1], [10, 25, 50, 100, 250, "Tudo"]],
		  'ordering'    	: true,
		  "order"			: [[ 3, "desc" ]],
		  "columnDefs"		: [
			{ targets: [0], orderable: false },
		]
		});
		
		//POPOVER
		jQuery('.img-popover').popover({
		  html: true,
		  trigger: 'hover',
		  content: function () {
			return '<img src="'+$(this).attr('src') + '" width="auto" height="auto" />';
		  }
		 });	

	});			
	</script>	  

<!-- Dropdowns -->
<div id="dropdown-retailers" class="jq-dropdown jq-dropdown-tip jq-dropdown-anchor-right">
    <ul class="jq-dropdown-menu">
      <li><a href="#">All Retailers</a></li>
      <li class="jq-dropdown-divider"></li>
        @foreach( $lojas as $value)
             <li><a href="#">{{$value->descricao}}</a></li>
        @endforeach
    </ul>
</div>
<div id="dropdown-categories" class="jq-dropdown jq-dropdown-tip jq-dropdown-anchor-right">
    <ul class="jq-dropdown-menu">
        <li><a href="#">All Categories</a></li>
        <li class="jq-dropdown-divider"></li>
        @foreach( $categorias as $value)
            <li><a href="#">{{$value->descricao}}</a></li>
        @endforeach

    </ul>
</div>

@stop

@endsection