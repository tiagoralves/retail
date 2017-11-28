<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">Category by Retailers</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-responsive text-center">
                    <div id="category_by_retailers_chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="row" id="category_by_retailers__categories">
        </div>
    </div>
    <!-- /.box-footer -->
    <div class="box-footer text-center">
        <a href="javascript:void(0)" class="uppercase" style="display:block;">more details</a>
    </div>
    <!-- /.box-footer -->
</div>
<!-- /.box -->

@section('pagescript')
    @parent
    <script>
        class CategoryByRetailerController{
            constructor(){
                console.log('CategoryByRetailerController()');
                this.resultCategoryByRetailers = {};
                this.loadData();
//                this.displayChart();
                //this.displayCategories();
            }
            loadData(callback){
                console.log('CategoryByRetailerController.loadData()');
                let that = this;
                jQuery.ajax({ type: "GET",
                    url: "/reports/json/category_by_retailers",
                    success : function(text)
                    {
                        that.resultCategoryByRetailers = JSON.parse(text);
                        that.displayChart();
                        that.displayCategories();
                    }
                });
            }
            displayChart(){
                console.log('CategoryByRetailerController.displayChart()');
                let that = this;
                jQuery('#category_by_retailers_chart').highcharts({
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
                        categories: that.resultCategoryByRetailers[1],
                        labels: {
                            align: 'center',
                            useHTML: true,
                            formatter: function () {
                                return "<img src='https://www.google.com/s2/favicons?domain="+this.value+"'>";
                            },
                        },
                    },{
                        categories: that.resultCategoryByRetailers[1],
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
                    series: that.resultCategoryByRetailers[0]
                }, function(chart) {
                    var extremes = chart.xAxis[0].getExtremes();
                    chart.xAxis[1].setExtremes(extremes.min-0.5,extremes.max+0.5);
                });
            }
            displayCategories(){
                console.log('CategoryByRetailerController.displayCategories()');
                jQuery.each(this.resultCategoryByRetailers[0], function(index, category){
                    let template = `
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block border-right">
                                <h5 class="description-header"><span class="glyphicon glyphicon-stop" style="color:${category.color};"></span>${category.name}</h5>
                                <span class="description-percentage text-green"><i class="fa fa-angle-up"></i>${category.variance}</span>
                            </div>
                        </div>
                    `;
                    jQuery('#category_by_retailers__categories').append(template);
                });
            }
        }
        let categoryByRetailerController = new CategoryByRetailerController();
    </script>
@endsection

