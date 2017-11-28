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
    </section>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"><img src="https://www.google.com/s2/favicons?domain=http://url" class="favicon-left">loja  - device  - data</h4>
        </div>
        <div class="modal-body">

            <!-- START CUSTOM TABS -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_homepage" data-toggle="tab">Homepage</a></li>
                            <li><a href="{{url("category/228")}}">Category</a></li>
                            <li><a href="{{url("search/228")}}">Search</a></li>
                            <li><a href="{{url("screenshot/228")}}">Screenshot</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_homepage">
                                <br />
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- tabs up -->
                                        <div class="tabs-up">
                                            <ul class="nav nav-tabs nav-tabs-btn">
                                                <li class="active"><a href="#tab_homepage_organic" data-toggle="tab">Organic</a></li>
                                                <li><a href="#tab_homepage_carousel" data-toggle="tab">Carousel</a></li>
                                                <li><a href="#tab_homepage_ads" data-toggle="tab">Ads</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_homepage_organic">
                                                    <div class="margin-bottom">
                                                        <table class="table table-striped" >
                                                            <tr>
                                                                <th style="width: 10px">#</th>
                                                                <th>Imagem</th>
                                                                <th>Produto</th>
                                                                <th>De</th>
                                                                <th>Por</th>
                                                                <th>Parc.</th>
                                                                <th>CTA</th>
                                                            </tr>
                                                           @foreach( $categorias as $value)

                                                            <tr>
                                                                <td>{{$value->position}}</td>
                                                                <td><img class="img-responsive" src="{{$value->imagem}}" alt="Photo"></td>
                                                                <td>{{$value->titulo}}</td>
                                                                <td>{{$value->preco}}</td>
                                                                <td>{{$value->preco_promocao}}</td>
                                                                <td>{{$value->preco_inicial}}</td>
                                                                <td></td>
                                                            </tr>
                                                         @endforeach

                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_homepage_carousel">
                                                    <div class="margin-bottom">
                                                        <table class="table table-striped">
                                                            <tr>
                                                                <th style="width: 10px">#</th>
                                                                <th>Imagem</th>
                                                            </tr>
                                                            @foreach( $carrossel as $value)
                                                            <tr>
                                                                <td>{{$value->position}}</td>
                                                                <td><img class="img-responsive" src="{{$value->imagem}}" alt="Photo"></td>
                                                            </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_homepage_ads">
                                                    <div class="margin-bottom">
                                                        <div class="gal">
                                                            @foreach($ads as $value)
                                                            <a href="#" target="_blank"><img class="img-responsive" src="{{$value->imagem}}" alt="Photo"></a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
@endsection