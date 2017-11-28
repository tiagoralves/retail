<div class="col-md-6">
    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title">Ads by Retailer</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="chart-responsive text-center">
                        <div id="container_adsbyretailers"></div>
                    </div>
                    <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="row">
                @foreach($adsByRetailer as $value)
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header"><span class="glyphicon glyphicon-stop" style="color:#272727;"></span> {{$value['categoria']}}</h5>
                        <span class="description-percentage text-green"><i class="fa fa-angle-up"></i> {{$value['countAdsRetailer']}}%</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                @endforeach

            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-footer -->
        <div class="box-footer text-center">
            <a href="javascript:void(0)" class="uppercase" style="display:block;">more details</a>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->