@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')

    <section class="content">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Filtros</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control select2" style="width: 100%;">
                                @foreach($paises as $value)
                                    <option value="{{$value->id}}" <?php if($value->pais=='Brasil'){?>selected="selected"<?php } ?>>{{$value->pais}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <select class="form-control select2" style="width: 100%;">
                                    <option selected="selected" disabled></option>
                                    @foreach($lojas as $loja)
                                        <option value="{{$loja->id}}">{{$loja->descricao}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control pull-right" id="data_range" type="text">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-1">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <div class="input-group btn-block">
                                <button class="btn btn-default btn-block">OK</button>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.box-body -->
        </div>

        <!-- Main row -->
        <div class="row">

            <div class="col-md-12">
                <h4 class="session">Organic</h4>
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4">
               @include('reports.share_of_shelf_component')
            </div>

            <div class="col-md-4">
                @include('reports.competitors_share_of_shelf_component')
            </div>

            <div class="col-md-4">
                @include('reports.search_coverage_component')
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-8">
                @include('reports.category_by_retailers_component')
            </div>

            <div class="col-md-4">
                @include('reports.popular_products_component')
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-12">
                <h4 class="session">Ads</h4>
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4">
                @include('reports.display_share_component')
            </div>

            <div class="col-md-8">
                @include('reports.ads_by_category_component')
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-6">
                @include('reports.ads_by_retailer_component')
            </div>

            <div class="col-md-6">
                @include('reports.ads_by_brand_component')
            </div>

            <div class="clearfix visible-sm-block"></div>

            {{--<div class="col-md-12">--}}
                {{--<div class="box box-default">--}}
                    {{--<div class="box-header">--}}
                        {{--<h3 class="box-title">Analysis & Insights</h3>--}}
                        {{--<div class="box-tools pull-right">--}}
                            {{--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="box-body">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut tempor, dui vitae mattis lacinia, est nibh tristique lorem, auctor tristique risus tellus ut nisl.</p>--}}
                                {{--<ul>--}}
                                    {{--<li>Etiam maximus ligula risus, ut varius turpis aliquet vel.</li>--}}
                                    {{--<li>Mauris placerat pulvinar lectus, vel condimentum massa tempor sed.</li>--}}
                                    {{--<li>Nulla in lectus porta leo fringilla pellentesque.</li>--}}
                                    {{--<li>Phasellus sagittis lectus id leo elementum luctus.</li>--}}
                                    {{--<li>Integer malesuada id leo quis tristique.</li>--}}
                                    {{--<li>Nullam hendrerit purus vel augue condimentum, et vehicula eros imperdiet.</li>--}}
                                {{--</ul>--}}
                                {{--<p>Integer a faucibus nibh, ut consequat lorem. Nulla quis tellus gravida, vestibulum elit ut, faucibus mi. Donec pellentesque mi nibh, sit amet dictum sapien maximus bibendum. Sed eu volutpat nibh, eu cursus lacus. Nam at diam sed magna laoreet consequat vel at nulla. Donec nisl ligula, gravida sit amet nunc a, cursus tincidunt mi.</p>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="clearfix visible-sm-block"></div>

        </div>

    </section>
    {{--<!-- /.content -->--}}
@endsection

@section('pagescript')
    @parent
    <script src="{{ asset('/plugins/select2.full.min.js')}}"></script>
    <script src="{{ asset('/plugins/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script>
        $(document).ready(function(){
            //Initialize Select2 Elements
            $('.select2').select2();
            //Date range picker
            $('#data_range').daterangepicker();
        });
    </script>
@endsection