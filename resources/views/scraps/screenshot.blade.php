@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
    <section class="content-header">
        <h1>
            Scraps
            <small>Lista com os últimos scraps por retailer</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/scraps">Scraps</a></li>
            <li class="active">Homepage</li>
        </ol>

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><img src="https://www.google.com/s2/favicons?domain=http://url" class="favicon-left">loja  - device  - data</h4>
            </div>
            <div class="modal-body">

                <!-- START CUSTOM TABS -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li ><a href="{{url("show/228")}}" >Homepage</a></li>
                                <li><a href="{{url("category/228")}}">Category</a></li>
                                <li><a href="{{url("search/228")}}">Search</a></li>
                                <li class="active"><a href="#">Screenshot</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_homepage">
                                    <br />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- tabs up -->
                                            <div class="tabs-up">
                                                <ul class="nav nav-tabs nav-tabs-btn">
                                                    <li class="active"><a href="#tab_search_1" data-toggle="tab"><i class="fa fa-file-picture-o left"></i>Homepage</a></li>
                                                    <li><a href="#tab_search_2" data-toggle="tab"><i class="fa fa-file-picture-o left"></i>TV</a></li>
                                                    <li><a href="#tab_search_3" data-toggle="tab"><i class="fa fa-file-picture-o left"></i>Washing Machine</a></li>
                                                    <li><a href="#tab_search_4" data-toggle="tab"><i class="fa fa-file-picture-o left"></i>Refrigerator</a></li>
                                                    <li><a href="#tab_search_5" data-toggle="tab"><i class="fa fa-file-picture-o left"></i>Smartphone</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab_search_1">
                                                        <div class="margin-bottom">

                                                            <a href="#" target="_blank"><img class="img-responsive" src="https://iprospectmonitor.com.br/dev/testes/_apagar/screenshot_sonar.jpg" alt="Photo"></a>

                                                        </div>
                                                    </div>
                                                    <!-- /tabs -->
                                                </div>
                                            <!-- /tabs -->
                                        </div>
                                    </div>
                                    <br />
                                    <!-- /row -->
                                </div>


                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- END CUSTOM TABS -->

            </div>
            <div class="modal-footer">

            </div>
        </div>
        </div>
    </section>
@endsection