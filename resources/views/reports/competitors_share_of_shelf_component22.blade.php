<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">Competitors Share of Shelf</h3>
        <div class="box-tools pull-right">
            <a class="dropdown-toggle label label-default2" data-toggle="dropdown" href="#">
                Categories <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Smartphone</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">TV</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Washing Machine</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Refrigerator</a></li>
            </ul>
            &nbsp;
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-responsive" id="competitors_of_shelf_chart">
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer text-center">
        <a href="javascript:void(0)" class="uppercase" style="display:block;">more details</a>
    </div>
</div>



@section('pagescript')
@parent
<script>
    class CompetitorsShareOfShelf{
        constructor(){
            console.log('CompetitorsShareOfShelf()');
            this.resultAjax = {};
            this.loadData();
        }
        loadData(){
            console.log('CompetitorsShareOfShelf.loadData()');
            let that = this;
            jQuery.ajax({ type: "GET",
               // url: "/reports/json/competitors_share_of_shelf",
                success : function(text)
                {
                    that.resultAjax = JSON.parse(text);
                    that.displayChart();
                }
            });
        }
        displayChart(){
            console.log('CompetitorsShareOfShelf.displayChart()');
            let that = this;
            jQuery(function() {
                var chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'competitors_of_shelf_chart',
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
                        data: that.resultAjax
                    }]
                });
            });
        }
    }
    let competitorsShareOfShelf = new CompetitorsShareOfShelf();

</script>
@endsection