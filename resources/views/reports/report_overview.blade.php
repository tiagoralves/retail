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
							<li class="active">Overview</li>
						</ol>
					</section>
				</div>
				
				<div class="col-md-2">
					<div class="form-group">
						<label>Country:</label>
						{!! Form::select('country',$countries,null, ['placeholder' => 'select Country', 'id'=>'country', 'class'=>'form-control countries'])!!}
					</div>
				</div>

				<!-- /.col -->
				<div class="col-md-3">
					<!-- /.form-group -->
					<div class="form-group">
						<label>Date range:</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input class="form-control pull-right" name="data" id="period" type="text">
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
							<select name="loja_id" id="loja_id" class="form-control countries" style="width:150px">
							</select>
						</div>
						
						<div class="btn-group">
						  {{--<span class="btn btn-default dropdown-toggle" data-jq-dropdown="#dropdown-categories" data-toggle="dropdown">
							All Categories <span class="caret"></span>
						  </span>--}}
							<select name="categoria_id" id="categoria_id" class="form-control countries" style="width:150px">
								<option>All Categories</option>
								@foreach( $categorias as $value)
									<option value="{{$value->id}}">{{$value->descricao}}</option>
								@endforeach
							</select>
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
	
	  <!-- Main row -->
      <div class="row">

		  @include('reports.share_of_shelf_component')
		  @include('reports.competitors_share_of_shelf_component')
		  @include('reports.search_coverage_component')
		  <div class="clearfix visible-sm-block"></div>
		  @include('reports.category_by_retailers_component')
		  @include('reports.popular_products_component')
		  <div class="clearfix visible-sm-block"></div>
		  @include('reports.display_share_component')
		  @include('reports.ads_by_category_component')
		  <div class="clearfix visible-sm-block"></div>
		  @include('reports.ads_by_retailer_component')

	  </div>
	   @include('reports.ads_by_brand_component')
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
	{{--<script src="{{ asset('/jquery/dist/jquery.min.js') }}"></script>--}}
    <script src="{{ asset('/jquery-ui/jquery-ui.min.js') }}"></script>	
    <script src="{{ asset('/plugins/select2.full.min.js')}}"></script>
    <script src="{{ asset('/plugins/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('/js/pages/dashboard.js')}}"></script>
    <script src="{{ asset('/plugins/highcharts/highcharts.js')}}"></script>
    <script src="{{ asset('/plugins/highcharts/modules/exporting.js')}}"></script>
    <script src="{{ asset('/jquery-knob/js/jquery.knob.js')}}"></script>
    <script src="{{ asset('/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
    <!-- Dropdown -->
    <script src="{{ asset('/plugins/jquery-dropdown/jquery.dropdown.js')}}" type="text/javascript"></script>

	<script>
		$('#country').change(function(){
			var countryID = $(this).val();
			if(countryID){
				$.ajax({
					type:"GET",
					url:"{{url('reports/get-loja-list')}}?country_id="+countryID,
					success:function(res){
						if(res){
							$("#loja_id").empty();
							$("#loja_id").append('<option>All Retailers</option>');
							$.each(res,function(key,value){
								$("#loja_id").append('<option value="'+key+'">'+value+'</option>');
							});

						}else{
							$("#state").empty();
						}
					}
				});
			}else{
				$("#loja_id").empty();
			}
		});

	</script>

<!-- Page script -->
<script type="text/javascript">
  $.widget.bridge('uibutton', $.ui.button);

jQuery(function() {

	
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
	
	jQuery(".sparkline-2").sparkline([22.2, 16.2, 14.9, 24.5, 29.1, 39.1], {
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
	
	jQuery(".sparkline-3").sparkline([42.2, 26.2, 37.9, 44.5, 39.1, 32.1], {
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
	
    jQuery('.sparkbar').sparkline('html', {
		type: 'bar',
		barColor: '#5fbf00',
		negBarColor: '#ff0000'
	});


	//Select2 Elements
	jQuery('.countries').select2()

	var date = new Date();
	var past = '';
	var today = new Date(date.getFullYear(), date.getMonth(), date.getDate()-7);

	$('#period').datepicker({
		todayHighlight: true,
		//startDate : today-2,
		endDate   : today
	});
	$('#period').datepicker('setDate', today);
	activeWeek();
	$('#period').on('changeDate', function() {
		$('#period').val($('#period').datepicker('getFormattedDate'));
		activeWeek();
	});

	function activeWeek() {
		$('.day.active').closest('tr').find('.day').addClass('active');
	}

	var dados = '<?php echo json_encode($percentualMarcas)?>' ;
	var dados =  JSON.parse(dados);

	var lojasJson = '<?php echo json_encode($lojasJson)?>' ;
	var lojasJson =  JSON.parse(lojasJson);

	var lojasUrlJson = '<?php echo json_encode($lojasUrlJson)?>' ;
	var lojasUrlJson =  JSON.parse(lojasUrlJson);

	var adsbycategoryCount = '<?php echo json_encode($adsbycategoryCount)?>' ;
	var adsbycategoryCount =  JSON.parse(adsbycategoryCount);

	var displayShare = '<?php echo json_encode($displayShare)?>' ;
	var displayShare =  JSON.parse(displayShare);

	var adsBrand = '<?php echo json_encode($adsBrand)?>' ;
	var adsBrand =  JSON.parse(adsBrand);

	var chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container_shareofshelf2',
			type: 'pie',
			spacingRight: 5,
			spacingTop: 10,
			spacingBottom: 10,
			spacingLeft: 5,
			height:186,
			},
			credits: {
				enabled: false
			},
			exporting: {
				enabled: false
			},
		title: {
			text: '',
		},
		plotOptions: {
			pie: {
				//allowPointSelect: true,
				//slicedOffset: 0,
				//cursor: 'default',
				showInLegend: true,
				innerSize: '80%',
				dataLabels: {
					enabled: false
				}
			},
			series: { cursor: 'pointer', },
		},
		legend: {
			enabled: true,
			layout: 'vertical',
			align: 'right',
			//width: 130,
			verticalAlign: 'middle',
		},
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
		 series: [{
			data: dados,
		}]
	},
	function(chart){});

	var chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container_displayshare',
			type: 'pie',
			spacingRight: 5,
			spacingTop: 10,
			spacingBottom: 10,
			spacingLeft: 5,
			height:186,
			},
			credits: {
				enabled: false
			},
			exporting: {
				enabled: false
			},
		title: {
			text: '',
		},
		plotOptions: {
			pie: {
				//allowPointSelect: true,
				//slicedOffset: 0,
				//cursor: 'default',
				showInLegend: true,
				innerSize: '80%',
				dataLabels: {
					enabled: false
				}
			},
			series: { cursor: 'pointer', },
		},
		legend: {
			enabled: true,
			layout: 'vertical',
			align: 'right',
			//width: 130,
			verticalAlign: 'middle',
		},
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
		 series: [{
			data: displayShare,
		}]
	},                            
	function(chart){});


	 //console.log(lojasJson);


	jQuery('#container_categorybyretailers').highcharts({
      credits: {
        enabled: false
      },


	   chart: {
			type: 'column',
			renderTo: 'chart',
			height:309,
			backgroundColor: '#FFFFFF',
			spacingTop: 0,
			spacingBottom: 0,		
			events: {
			  load: function(event) {
				event.target.reflow();
			  }
			}
        },
        title: {
          text: ''
        },
        subtitle: {
          text: ''
        },
        exporting: {
          enabled: false
        },	            
        xAxis: [{
				categories: lojasUrlJson,
          labels: {
            align: 'center',
            useHTML: true,                        
            formatter: function () {
              return "<img src='https://www.google.com/s2/favicons?domain="+this.value+"'>";
            },        
          },	 
        },{
				categories: lojasJson,
          labels: {
            y:18,
            rotation: 0,
            align: 'center',
				formatter: function() {
					return this.value;
				}            
          },
          lineWidth: 0,
          minorGridLineWidth: 0,
          lineColor: 'transparent', 
          minorTickLength: 0,
          tickLength: 0             
        }],
        yAxis: {
          min: 0,
          gridLineColor: 'transparent',
          gridLineDashStyle: 'longdash',
          title: {
            text: ''
          },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            },
            labels: {
              enabled: false
            },	            
        },
        legend: {
			enabled: false,
        },
        tooltip: {
          useHTML: true,
          formatter: function() {
            highperc = (this.y/this.y)*100;
						highperc = highperc.toFixed(0);
            return '<div style="font-family: Arial, Tahoma; width:100px; height:72px; padding:0px;"><div style="color:#4C5962; font-size:11px; width:100px; height:22px; padding:0px;"><b>'+ this.series.name +'</b></div><div style="color:#FFF; width:100px; font-size:24px;float:left; margin-right:5px; padding:6px; text-align:center; background-color:'+this.series.color+';"><strong>'+this.y+'</strong><div style="font-size:8px; text-align:center;">INSERTIONS</div></div></div>';
          },
          borderRadius: 3,
          borderWidth: 3
        },        
        plotOptions: {
          column: {
            size:'100%',
            shadow: false,
            //stacking: 'normal',
            dataLabels: {
              enabled: true,
              color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black',
              style: {
              }
            }
          },
        },            
        series: [{
			name: 'Smartphone',
			color: '#272727',
            data: [221,113,331,201,127,161,117,181,219,100]
        }, {
            name: 'TV',
            color: '#5b9bd5',
            data: [172,222,313,114,125,263,117,182,149,280]
        }, {
            name: 'Washing Machine',
            color: '#70ad47',
            data: [112,192,123,214,115,265,117,135,119,190]
        },{
            name: 'Refrigerator',
            color: '#7030a0',
            visible: true,
            data: [121,192,113,204,155,116,171,174,129,150]
          }
        ]
        }, function(chart) {
        var extremes = chart.xAxis[0].getExtremes();
        chart.xAxis[1].setExtremes(extremes.min-0.5,extremes.max+0.5);
     });
	 
	jQuery('#container_adsbyretailers').highcharts({
      credits: {
        enabled: false
      },  
	   chart: {
			type: 'column',
			renderTo: 'chart',
			height:250,
			backgroundColor: '#FFFFFF',
			spacingTop: 0,
			spacingBottom: 0,		
			events: {
			  load: function(event) {
				event.target.reflow();
			  }
			}
        },
        title: {
          text: ''
        },
        subtitle: {
          text: ''
        },
        exporting: {
          enabled: false
        },	            
        xAxis: [{
				categories: ['americanas.com.br','carrefour.com.br','casasbahia.com.br','extra.com.br','fastshop.com.br','magazineluiza.com.br','pontofrio.com.br','ricardoeletro.com.br','submarino.com','walmart.com.br'],
          labels: {
            align: 'center',
            useHTML: true,                        
            formatter: function () {
              return "<img src='https://www.google.com/s2/favicons?domain="+this.value+"'>";
            },        
          },	 
        },{
				categories: ['americanas.com.br','carrefour.com.br','casasbahia.com.br','extra.com.br','fastshop.com.br','magazineluiza.com.br','pontofrio.com.br','ricardoeletro.com.br','submarino.com','walmart.com.br'],
          labels: {
            y:18,
            rotation: 0,
            align: 'center',
				formatter: function() {
					return this.value;
				}            
          },
          lineWidth: 0,
          minorGridLineWidth: 0,
          lineColor: 'transparent', 
          minorTickLength: 0,
          tickLength: 0             
        }],
        yAxis: {
          min: 0,
          gridLineColor: 'transparent',
          gridLineDashStyle: 'longdash',
          title: {
            text: ''
          },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            },
            labels: {
              enabled: false
            },	            
        },
        legend: {
			enabled: false,
        },
        tooltip: {
          useHTML: true,
          formatter: function() {
            highperc = (this.y/this.y)*100;
			highperc = highperc.toFixed(0);
            return '<div style="font-family: Arial, Tahoma; width:100px; height:72px; padding:0px;"><div style="color:#4C5962; font-size:11px; width:100px; height:22px; padding:0px;"><b>'+ this.series.name +'</b></div><div style="color:#FFF; width:100px; font-size:24px;float:left; margin-right:5px; padding:6px; text-align:center; background-color:'+this.series.color+';"><strong>'+this.y+'</strong><div style="font-size:8px; text-align:center;">INSERTIONS</div></div></div>';
          },
          borderRadius: 3,
          borderWidth: 3
        },        
        plotOptions: {
          column: {
            size:'100%',
            shadow: false,
            //stacking: 'normal',
            dataLabels: {
              enabled: true,
              color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black',
              style: {
              }
            }
          },
        },            
        series: [{
			name: 'Smartphone',
			color: '#272727',
            data: [21,103,31,144,127,61,17,81,19,100]
        }, {
            name: 'TV',
            color: '#5b9bd5',
            data: [72,22,33,14,25,63,17,82,49,80]
        }, {
            name: 'Washing Machine',
            color: '#70ad47',
            data: [112,92,23,14,15,65,17,35,19,90]
        },{
            name: 'Refrigerator',
            color: '#7030a0',
            visible: true,
            data: [11,92,13,54,55,16,71,74,29,50]
          }
        ]
        }, function(chart) {
        var extremes = chart.xAxis[0].getExtremes();
        chart.xAxis[1].setExtremes(extremes.min-0.5,extremes.max+0.5);
     });	 
	 
	Highcharts.chart('container_adsbycategory', {
		chart: {
			type: 'column',
			height:274,
		},
		title: {
			text: ''
		},
        exporting: {
          enabled: false
        },
		credits: {
			enabled: false
		},		
		xAxis: {
			categories: ['Week 28','Week 29','Week 30','Week 31','Week 32','Week 33','Week 34','Week 35','Week 36','Week 37']
		},
		yAxis: {
					min:0,
			max:100,
			title: {
				text: ''
			}
		},
		tooltip: {
			pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
			shared: true
		},
		plotOptions: {
			column: {
				stacking: 'percent'
			},
				series: {
					dataLabels: {
						enabled: false,
						formatter: function() {
							return Math.round(this.percentage*100)/100 + ' %';
						},
						distance: -30,
						color:'white'
					}
				}        
		},
			series: adsbycategoryCount
	});

	jQuery('#container_adsbybrands').highcharts({
      credits: {
        enabled: false
      },  
		chart: {
			type: 'column',
			renderTo: 'chart',
			height:330,
			backgroundColor: '#FFFFFF',
			marginTop: 0,
			events: {
			  load: function(event) {
				event.target.reflow();
			  }
			}
        },
        title: {
          text: ''
        },
        subtitle: {
          text: ''
        },
        exporting: {
          enabled: false
        },	            
        xAxis: [{
				categories: ['samsung.com.br','apple.com.br','lge.com.br','sony.com.br','motorola.com.br','huawei.com','lenovo.com.br','meuquantum.com.br','loja.asus.com.br'],
          labels: {
            align: 'center',
            useHTML: true,                        
            formatter: function () {
              return "<img src='https://www.google.com/s2/favicons?domain="+this.value+"'>";
            },        
          },	 
        },{
				categories: ['samsung.com.br','apple.com.br','lge.com.br','sony.com.br','motorola.com.br','huawei.com','lenovo.com.br','quantum.com.br','asus.com.br'],
          labels: {
            y:18,
            rotation: 0,
            align: 'center',
						formatter: function() {
              return this.value;
						}            
          },
          lineWidth: 0,
          minorGridLineWidth: 0,
          lineColor: 'transparent', 
          minorTickLength: 0,
          tickLength: 0,                     
          //opposite: true
        }],
        yAxis: {
          min: 0,
          gridLineColor: 'transparent',
          gridLineDashStyle: 'longdash',
          title: {
            text: ''
          },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            },
            labels: {
              enabled: false
            },	            
        },
        legend: {
			enabled: false
        },
        tooltip: {
          useHTML: true,
          formatter: function() {
            highperc = (this.y/200)*100;
			highperc = highperc.toFixed(0);
            return '<div style="color:#FFF; width:100px; font-size:24px;float:left; margin-right:5px; padding:6px; text-align:center; background-color:'+this.series.color+';"><strong>'+this.y+'</strong><div style="font-size:8px; text-align:center;">INSERTIONS</div></div></div>';
            //return '<div style="font-family: Arial, Tahoma; width:124px; height:72px; padding:0px;"><div style="color:#4C5962; font-size:11px; width:124px; height:22px; padding:0px;"><b>'+ this.series.name +'</b></div><div style="color:#FFF; width:40px; font-size:24px;float:left; margin-right:5px; padding:6px; text-align:center; background-color:'+this.series.color+';"><strong>'+this.y+'</strong><div style="font-size:8px; text-align:center;">PALAVRAS</div></div><div style="color:#4C5962; width:50px; font-size:24px;float:left; margin-right:5px; background-color:#E8EAEB; padding:6px; text-align:center;"><strong>'+highperc+'%</strong><div style="font-size:8px; text-align:center;">DO TOTAL</div></div></div>';
          },
          borderRadius: 3,
          borderWidth: 3
        },        
        plotOptions: {
          column: {
            size:'100%',
            shadow: false,
            //stacking: 'normal',
            dataLabels: {
              enabled: true,
              color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black',
              style: {
              }
            }
          },
        },            
        series: [{
			//name: '',
			//color: '#272727',
            data: adsBrand
        }
        ]
	}, function(chart) {
	var extremes = chart.xAxis[0].getExtremes();
	chart.xAxis[1].setExtremes(extremes.min-0.5,extremes.max+0.5);
	});
	
});

</script>
	
<!-- Dropdowns -->
{{--
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
--}}

@stop

@endsection
