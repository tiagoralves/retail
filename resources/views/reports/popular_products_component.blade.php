<div class="col-md-4">
    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title">Popular Products</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="">
                <table class="table no-margin">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Popularity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($produtos as $value)
                        <tr>
                            <td  style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{$value->produto}}">{{substr($value->produto, 0, 35)}}</td>
                            <td>
                                <div class="sparkbar pull-right" data-color="#00a65a" data-height="20">70,-40,22,37,-44,43,-13, 50</div>
                            </td>
                        </tr>
                     @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
            <a href="report_products.html" class="uppercase" style="display:block;">more details</a>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>