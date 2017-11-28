@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
    {!! Html::style('css/bootstrap.css') !!}
    {!! Html::style('plugins/font-awesome/css/font-awesome.min.css') !!}
    {!! Html::style('plugins/Ionicons/css/ionicons.min.css') !!}
    {!! Html::style('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
    {!! Html::style('css/all.css') !!}


    <!-- Content Wrapper. Contains page content -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Scraps
                <small>Lista com os últimos scraps por retailer</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Retail</a></li>
                <li class="active">Scraps</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table id="scraps" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="visible-md visible-lg">País</th>
                                    <th>Retailer</th>
                                    <th>Device</th>
                                    <th>Data</th>
                                    <th class="no-sort center visible-md visible-lg">Período</th>
                                    <th class="no-sort icon center 3btn"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($scraps as $value)
                                    <?print_r($value); exit;?>
                                <tr>
                                    <td class="visible-md visible-lg"><span class="flag-icon flag-icon-left flag-icon-br"></span><a href="#">País</a></td>
                                    <td><img src="https://www.google.com/s2/favicons?domain=http://www.casasbahia.com.br/" class="favicon-left"><a href="#">Casas Bahia</a></td>
                                    <td>Mobile</td>
                                    <td>{{$value['created_at']}}</td>
                                    <td class="center visible-md visible-lg">
                                        <div class="btn-action3">
                                            <span class="btn-sm bg-teal" data-tt="tooltip" title="Manhã"><i class="fa fa-cloud"></i></span>
                                            <span class="btn-sm bg-orange" data-tt="tooltip" title="Tarde"><i class="fa fa-sun-o"></i></span>
                                            <span class="btn-sm bg-gray-fail"><i class="fa fa-moon-o"></i></span>
                                        </div>
                                    </td>
                                    <td class="center">
                                        <div class="btn-group btn-action3">
                                            <a href="#" data-toggle="modal" data-target="#modal-ver" data-backdrop="static" data-keyboard="false" data-tt="tooltip" title="Preview" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="#" data-tt="tooltip" title="Histórico"  class="btn btn-default btn-sm"><i class="fa fa-history"></i></a>
                                            <a href="#" data-tt="tooltip" title="Excluir"  class="btn btn-default btn-sm"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach


                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="visible-md visible-lg">País</th>
                                    <th>Retailer</th>
                                    <th>Device</th>
                                    <th>Data</th>
                                    <th class="no-sort center visible-md visible-lg">Período</th>
                                    <th class="no-sort icon center 3btn"></th>
                                </tr>
                                </tfoot>
                            </table>

                            <!-- MODAL -->
                            <div class="modal" id="modal-ver" style="display:none;"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title"><img src="https://www.google.com/s2/favicons?domain=http://www.casasbahia.com.br/" class="favicon-left">Casas Bahia - Desktop - 26/08/2017</h4>
                                        </div>
                                        <div class="modal-body">

                                            <!-- START CUSTOM TABS -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- Custom Tabs -->
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                            <li class="active"><a href="#tab_homepage" data-toggle="tab">Homepage</a></li>
                                                            <li><a href="#tab_category" data-toggle="tab">Category</a></li>
                                                            <li><a href="#tab_search" data-toggle="tab">Search</a></li>
                                                            <li><a href="#tab_screenshots" data-toggle="tab">Screenshot</a></li>
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
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Acimade10kg/3986730/98330994/Lavadora-de-Roupas-Electrolux-15-kg-Turbo-Economia-LTD15-Branca-3986730.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 13 kg Alta Capacidade LT13B - Branca</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.299,00</td>
                                                                                                <td>ou 12X de R$ 108,25 sem juros</td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/UtilidadesDomesticas/Panelas/conjuntodepanelas/11668969/852250199/conjunto-de-panelas-tramontina-turim-aluminio-10-pecas-11668969.jpg" alt="Photo"></a></td>
                                                                                                <td>Conjunto de Panelas Tramontina Paris 20599764 Vermelho - 6 Peças</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/4793652/114318667/Smart-TV-LED-32-HD-Samsung-32J4300-com-Connect-Share-Movie-Screen-Mirroring-Wi-Fi-Entradas-HDMI-e-Entrada-USB-4793652.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 32" HD Samsung 32J4300 com Connect Share Movie, Screen Mirroring, Wi-Fi, Entradas HDMI e Entrada USB</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/9368114/525083717/smartphone-moto-g4-play-dtv-colors-xt1603-preto-com-tv-16gb-tela-de-5-dual-chip-android-6-0-4g-camera-8mp-processador-quad-core-e-2gb-de-ram-9368114.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Moto G4 Play DTV Colors XT1603 Preto com TV, 16GB, Tela de 5'', Dual Chip, Android 6.0, 4G, Câmera 8MP, Processador Quad-Core e 2GB de RAM</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/LavadorasLavaeSeca/1866349/8192384/lava-e-seca-samsung-wd106uhsawq-az-branca-com-display-digital-sistema-air-wash-e-5-programas-de-lavagem-101kg-1866349.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Brastemp 11 kg BWJ11AB com Turbo Performance – Branca</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td></td>
                                                                                            </tr>
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
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/banner-tv/2017-08-25/Home-Banner-TV1-1p.png" alt="Photo"></a></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/banner-tv/2017-08-25/Home-Banner-TV2-1p.png" alt="Photo"></a></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/banner-tv/2017-08-25/Home-Banner-TV3-1p.png" alt="Photo"></a></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/banner-tv/2017-08-25/Home-Banner-TV4-1p.png" alt="Photo"></a></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/banner-tv/2017-08-25/Home-Banner-TV5-1p.png" alt="Photo"></a></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>6</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/banner-tv/2017-08-25/banner-home-cartao.png" alt="Photo"></a></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>7</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/banner-tv/2017-08-24/cb-banner-tv-moto-G5S.png" alt="Photo"></a></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane" id="tab_homepage_ads">
                                                                                    <div class="margin-bottom">
                                                                                        <div class="gal">
                                                                                            <a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/2017/banner-mosaico/2017-08-25/home-mosaico-1.png" alt="Photo"></a>
                                                                                            <a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/2017/banner-mosaico/2017-08-25/home-mosaico-2.png" alt="Photo"></a>
                                                                                            <a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/2017/banner-mosaico/2017-08-25/home-mosaico-3.png" alt="Photo"></a>
                                                                                            <a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/2017/banner-mosaico/2017-08-25/home-mosaico-4.png" alt="Photo"></a>
                                                                                            <a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/2017/banner-home/banner-conceitual/2017-08-25/conceitual-01.png" alt="Photo"></a>
                                                                                            <a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/2017/banner-home/banner-conceitual/2017-08-23/conceitual-02-v2.png" alt="Photo"></a>
                                                                                            <a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/2017/banner-home/banner-conceitual/2017-08-23/conceitual-03.png" alt="Photo"></a>
                                                                                            <a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/2017/banner-home/banner-conceitual/2017-08-23/conceitual-04.png" alt="Photo"></a>
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
                                                            <!-- /.tab-pane -->
                                                            <div class="tab-pane" id="tab_category">
                                                                <br />
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <!-- tabs up -->
                                                                        <div class="tabs-up">
                                                                            <ul class="nav nav-tabs nav-tabs-btn">
                                                                                <li class="active"><a href="#tab_category_1" data-toggle="tab">Refrigerators</a></li>
                                                                                <li><a href="#tab_category_2" data-toggle="tab">Smartphones</a></li>
                                                                                <li><a href="#tab_category_3" data-toggle="tab">TVs</a></li>
                                                                                <li><a href="#tab_category_4" data-toggle="tab">Washing Machines</a></li>
                                                                            </ul>
                                                                            <div class="tab-content">
                                                                                <div class="tab-pane active" id="tab_category_1">
                                                                                    <div class="margin-bottom">
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/2Portas/1743666/6628730/Refrigerador-Electrolux-Duplex-DC35A-260L-Branco-1743666.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/46703/3091851/refrigerador-brastemp-clean-brm39eb-frost-free-duplex-352l-branco-46703.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/4769554/153964623/Refrigerador-Electrolux-DFN42-Frost-Free-com-Painel-Blue-Touch-370-L-Branco-4769554.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/370868/3521923/Refrigerador-Electrolux-Duplex-DW42X-Frost-Free-com-Dispenser-de-Agua-e-Controle-de-Temperatura-Blue-Touch-380-L-Inox-370868.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/2Portas/3384187/45252399/refrigerador-consul-cycle-defrost-crd36gb-duplex-com-super-freezer-334-l-branco-3384187.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane" id="tab_category_2">
                                                                                    <div class="margin-bottom">
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/8753332/566614305/smartphone-samsung-galaxy-j7-duos-metal-dourado-com-16gb-dual-chip-tela-5-5-4g-camera-13mp-android-6-0-e-processador-octa-core-de-1-6-ghz-8753332.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Samsung Galaxy J7 Duos Metal Dourado com 16GB, Dual chip, Tela 5.5", 4G, Câmera 13MP, Android 6.0 e Processador Octa Core de 1.6 Ghz</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/11248667/801287556/smartphone-motorola-moto-g5-xt1672-platinum-com-32gb-tela-de-5-dual-chip-android-7-0-4g-camera-13mp-processador-octa-core-e-2gb-de-ram-11248667.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Samsung Galaxy J7 Duos Metal Dourado com 16GB, Dual chip, Tela 5.5", 4G, Câmera 13MP, Android 6.0 e Processador Octa Core de 1.6 Ghz</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/10476497/597796400/smartphone-samsung-galaxy-j7-prime-duos-dourado-com-32gb-tela-5-5-dual-chip-4g-camera-13mp-leitor-biometrico-android-6-0-e-processador-octacore-10476497.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Samsung Galaxy J7 Duos Metal Dourado com 16GB, Dual chip, Tela 5.5", 4G, Câmera 13MP, Android 6.0 e Processador Octa Core de 1.6 Ghz</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/7316834/337927413/smartphone-samsung-galaxy-j1-mini-duos-dourado-com-dual-chip-tela-4-0-3g-camera-de-5mp-android-5-1-e-processador-quad-core-de-1-2-ghz-7316834.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Samsung Galaxy J7 Duos Metal Dourado com 16GB, Dual chip, Tela 5.5", 4G, Câmera 13MP, Android 6.0 e Processador Octa Core de 1.6 Ghz</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/11248695/801288727/smartphone-motorola-moto-g5-xt1672-ouro-com-32gb-tela-de-5-dual-chip-android-7-0-4g-camera-13mp-processador-octa-core-e-2gb-de-ram-11248695.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Samsung Galaxy J7 Duos Metal Dourado com 16GB, Dual chip, Tela 5.5", 4G, Câmera 13MP, Android 6.0 e Processador Octa Core de 1.6 Ghz</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane" id="tab_category_3">
                                                                                    <div class="margin-bottom">
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/10030427/569467295/Smart-TV-LED-40-Full-HD-Samsung-40K5300-com-Plataforma-Tizen-Conectividade-com-Smartphones-Audio-Frontal-Conversor-Digital-Wi-Fi-2-HDMI-e-1-USB-10030427.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 40" Full HD Samsung 40K5300 com Plataforma Tizen, Conectividade com Smartphones, Áudio Frontal, Conversor Digital, Wi-Fi, 2 HDMI e 1 USB</td>
                                                                                                <td>R$ 2.158,92</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>ou 12X de R$ 141,58 sem juros</td>
                                                                                                <td>Retira CasasBahia</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/4793652/114318667/Smart-TV-LED-32-HD-Samsung-32J4300-com-Connect-Share-Movie-Screen-Mirroring-Wi-Fi-Entradas-HDMI-e-Entrada-USB-4793652.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 40" Full HD Samsung 40K5300 com Plataforma Tizen, Conectividade com Smartphones, Áudio Frontal, Conversor Digital, Wi-Fi, 2 HDMI e 1 USB</td>
                                                                                                <td>R$ 2.158,92</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>ou 12X de R$ 141,58 sem juros</td>
                                                                                                <td>Retira CasasBahia</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/11458137/817304966/smart-tv-led-43-full-hd-lg-43lj5550-com-painel-ips-wi-fi-webos-3-5-time-machine-ready-magic-zoom-quick-access-hdmi-e-usb-11458137.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 40" Full HD Samsung 40K5300 com Plataforma Tizen, Conectividade com Smartphones, Áudio Frontal, Conversor Digital, Wi-Fi, 2 HDMI e 1 USB</td>
                                                                                                <td>R$ 2.158,92</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>ou 12X de R$ 141,58 sem juros</td>
                                                                                                <td>Retira CasasBahia</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/11458130/817110054/smart-tv-led-32-hd-lg-32lj600b-com-wi-fi-webos-3-5-time-machine-ready-magic-zoom-quick-access-hdmi-e-usb-11458130.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 40" Full HD Samsung 40K5300 com Plataforma Tizen, Conectividade com Smartphones, Áudio Frontal, Conversor Digital, Wi-Fi, 2 HDMI e 1 USB</td>
                                                                                                <td>R$ 2.158,92</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>ou 12X de R$ 141,58 sem juros</td>
                                                                                                <td>Retira CasasBahia</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/11314871/800799323/Smart-TV-LED-39-HD-Philco-PH39N91DSGWA-com-Wi-Fi-ApToide-Som-Surround-MidiaCast-Entradas-HDMI-e-USB-11314871.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 40" Full HD Samsung 40K5300 com Plataforma Tizen, Conectividade com Smartphones, Áudio Frontal, Conversor Digital, Wi-Fi, 2 HDMI e 1 USB</td>
                                                                                                <td>R$ 2.158,92</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>ou 12X de R$ 141,58 sem juros</td>
                                                                                                <td>Retira CasasBahia</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane" id="tab_category_4">
                                                                                    <div class="margin-bottom">
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Acimade10kg/3380807/45132095/Lavadora-de-Roupas-Electrolux-10-kg-LT10B-Turbo-Capacidade-e-Exclusiva-Tecla-Economia-3380806.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 10 kg LT10B Turbo Capacidade e Exclusiva Tecla Economia</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>R$ 1.349,00</td>
                                                                                                <td>ou 12X de R$ 91,58 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Acimade10kg/3986730/98330994/Lavadora-de-Roupas-Electrolux-15-kg-Turbo-Economia-LTD15-Branca-3986730.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 10 kg LT10B Turbo Capacidade e Exclusiva Tecla Economia</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>R$ 1.349,00</td>
                                                                                                <td>ou 12X de R$ 91,58 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Lavadorasde7kge9kg/3391377/155973559/Lavadora-de-Roupas-Consul-8-Kg-CWC08ABANA-Dispenser-Dose-Certa-Branca-3391377.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 10 kg LT10B Turbo Capacidade e Exclusiva Tecla Economia</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>R$ 1.349,00</td>
                                                                                                <td>ou 12X de R$ 91,58 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Acimade10kg/4060190/94235489/Lavadora-de-Roupas-Consul-10-Kg-Facilite-CWE10A-com-Dispenser-Flex-Branca-4060190.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 10 kg LT10B Turbo Capacidade e Exclusiva Tecla Economia</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>R$ 1.349,00</td>
                                                                                                <td>ou 12X de R$ 91,58 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Acimade10kg/3925053/833332519/Lavadora-de-Roupas-Electrolux-12-kg-Turbo-Capacidade-LT12B-3925053.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 10 kg LT10B Turbo Capacidade e Exclusiva Tecla Economia</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>R$ 1.349,00</td>
                                                                                                <td>ou 12X de R$ 91,58 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                        </table>
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
                                                            <!-- /.tab-pane -->
                                                            <div class="tab-pane" id="tab_search">
                                                                <br />
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <!-- tabs up -->
                                                                        <div class="tabs-up">
                                                                            <ul class="nav nav-tabs nav-tabs-btn">
                                                                                <li class="active"><a href="#tab_search_1" data-toggle="tab"><i class="fa fa-search left"></i>geladeira inox</a></li>
                                                                                <li><a href="#tab_search_2" data-toggle="tab"><i class="fa fa-search left"></i>geladeira duplex</a></li>
                                                                                <li><a href="#tab_search_3" data-toggle="tab"><i class="fa fa-search left"></i>geladeira inverse</a></li>
                                                                                <li><a href="#tab_search_4" data-toggle="tab"><i class="fa fa-search left"></i>celular 2 chips</a></li>
                                                                                <li><a href="#tab_search_5" data-toggle="tab"><i class="fa fa-search left"></i>tv 4k</a></li>
                                                                                <li><a href="#tab_search_6" data-toggle="tab"><i class="fa fa-search left"></i>lavadora de roupas 10kg</a></li>
                                                                            </ul>
                                                                            <div class="tab-content">
                                                                                <div class="tab-pane active" id="tab_search_1">
                                                                                    <div class="margin-bottom">
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/10990046/748221217/Geladeira-Consul-Frost-Free-340-Litros-Evox-10990050.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/5494828/187463985/Refrigerador-Brastemp-Inverse-BRE50NK-Ative-Evox-422-L-5494828.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/8439021/748238467/Refrigerador-Consul-Bem-Estar-450-Litros-Evox--8439021.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/5494824/187463407/Refrigerador-Brastemp-BRM39EK-Frost-Free-Clean-Evox-352-L-5494824.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/SidebySide/4420014/738224955/Refrigerador-Brastemp-Side-Inverse-BRO80AK-Evox-540L-4420014.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane" id="tab_search_2">
                                                                                    <div class="margin-bottom">
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/4769554/153964623/Refrigerador-Electrolux-DFN42-Frost-Free-com-Painel-Blue-Touch-370-L-Branco-4769554.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/370868/3521923/Refrigerador-Electrolux-Duplex-DW42X-Frost-Free-com-Dispenser-de-Agua-e-Controle-de-Temperatura-Blue-Touch-380-L-Inox-370868.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/2Portas/1743666/6628730/Refrigerador-Electrolux-Duplex-DC35A-260L-Branco-1743666.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/46703/3091851/refrigerador-brastemp-clean-brm39eb-frost-free-duplex-352l-branco-46703.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/2Portas/3384187/45252399/refrigerador-consul-cycle-defrost-crd36gb-duplex-com-super-freezer-334-l-branco-3384187.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane" id="tab_search_3">
                                                                                    <div class="margin-bottom">
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/5494828/187463985/Refrigerador-Brastemp-Inverse-BRE50NK-Ative-Evox-422-L-5494828.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/SidebySide/4420011/245409421/Refrigerador-Brastemp-Side-Inverse-BRO80AB-Branco-540L-4420011.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/1691558/166045717/Refrigerador-Brastemp-Ative-Inverse-Maxi-BRE80-Frost-Free-com-Controle-Eletronico-573L-Branco-1691558.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/FrostFree/306521/244788507/Refrigerador-Brastemp-Duplex-Ative-Inverse-BRE50NB-Frost-Free-com-Controle-Eletronico-422L-Branco-306520.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/GeladeiraeRefrigerador/11459900/814660879/geladeira-brastemp-viva-inverse-frost-free-422-litros-11459900.jpg" alt="Photo"></a></td>
                                                                                                <td>Refrigerador Electrolux Duplex DC35A 260L - Branco</td>
                                                                                                <td>R$ 1.399,00</td>
                                                                                                <td>R$ 1.199,00</td>
                                                                                                <td>ou 12X de R$ 99,92 sem juros</td>
                                                                                                <td>Entrega Expressa</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane" id="tab_search_4">
                                                                                    <div class="margin-bottom">
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/8753332/566614305/smartphone-samsung-galaxy-j7-duos-metal-dourado-com-16gb-dual-chip-tela-5-5-4g-camera-13mp-android-6-0-e-processador-octa-core-de-1-6-ghz-8753332.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Samsung Galaxy J7 Duos Metal Dourado com 16GB, Dual chip, Tela 5.5", 4G, Câmera 13MP, Android 6.0 e Processador Octa Core de 1.6 Ghz</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/11248667/801287556/smartphone-motorola-moto-g5-xt1672-platinum-com-32gb-tela-de-5-dual-chip-android-7-0-4g-camera-13mp-processador-octa-core-e-2gb-de-ram-11248667.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Samsung Galaxy J7 Duos Metal Dourado com 16GB, Dual chip, Tela 5.5", 4G, Câmera 13MP, Android 6.0 e Processador Octa Core de 1.6 Ghz</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/10476497/597796400/smartphone-samsung-galaxy-j7-prime-duos-dourado-com-32gb-tela-5-5-dual-chip-4g-camera-13mp-leitor-biometrico-android-6-0-e-processador-octacore-10476497.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Samsung Galaxy J7 Duos Metal Dourado com 16GB, Dual chip, Tela 5.5", 4G, Câmera 13MP, Android 6.0 e Processador Octa Core de 1.6 Ghz</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/7316834/337927413/smartphone-samsung-galaxy-j1-mini-duos-dourado-com-dual-chip-tela-4-0-3g-camera-de-5mp-android-5-1-e-processador-quad-core-de-1-2-ghz-7316834.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Samsung Galaxy J7 Duos Metal Dourado com 16GB, Dual chip, Tela 5.5", 4G, Câmera 13MP, Android 6.0 e Processador Octa Core de 1.6 Ghz</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/TelefoneseCelulares/Smartphones/Android/11248695/801288727/smartphone-motorola-moto-g5-xt1672-ouro-com-32gb-tela-de-5-dual-chip-android-7-0-4g-camera-13mp-processador-octa-core-e-2gb-de-ram-11248695.jpg" alt="Photo"></a></td>
                                                                                                <td>Smartphone Samsung Galaxy J7 Duos Metal Dourado com 16GB, Dual chip, Tela 5.5", 4G, Câmera 13MP, Android 6.0 e Processador Octa Core de 1.6 Ghz</td>
                                                                                                <td>R$ 1.299,99</td>
                                                                                                <td>R$ 799,00</td>
                                                                                                <td>ou 10X de R$ 79,90 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane" id="tab_search_5">
                                                                                    <div class="margin-bottom">
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/10030427/569467295/Smart-TV-LED-40-Full-HD-Samsung-40K5300-com-Plataforma-Tizen-Conectividade-com-Smartphones-Audio-Frontal-Conversor-Digital-Wi-Fi-2-HDMI-e-1-USB-10030427.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 40" Full HD Samsung 40K5300 com Plataforma Tizen, Conectividade com Smartphones, Áudio Frontal, Conversor Digital, Wi-Fi, 2 HDMI e 1 USB</td>
                                                                                                <td>R$ 2.158,92</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>ou 12X de R$ 141,58 sem juros</td>
                                                                                                <td>Retira CasasBahia</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/4793652/114318667/Smart-TV-LED-32-HD-Samsung-32J4300-com-Connect-Share-Movie-Screen-Mirroring-Wi-Fi-Entradas-HDMI-e-Entrada-USB-4793652.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 40" Full HD Samsung 40K5300 com Plataforma Tizen, Conectividade com Smartphones, Áudio Frontal, Conversor Digital, Wi-Fi, 2 HDMI e 1 USB</td>
                                                                                                <td>R$ 2.158,92</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>ou 12X de R$ 141,58 sem juros</td>
                                                                                                <td>Retira CasasBahia</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/11458137/817304966/smart-tv-led-43-full-hd-lg-43lj5550-com-painel-ips-wi-fi-webos-3-5-time-machine-ready-magic-zoom-quick-access-hdmi-e-usb-11458137.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 40" Full HD Samsung 40K5300 com Plataforma Tizen, Conectividade com Smartphones, Áudio Frontal, Conversor Digital, Wi-Fi, 2 HDMI e 1 USB</td>
                                                                                                <td>R$ 2.158,92</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>ou 12X de R$ 141,58 sem juros</td>
                                                                                                <td>Retira CasasBahia</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/11458130/817110054/smart-tv-led-32-hd-lg-32lj600b-com-wi-fi-webos-3-5-time-machine-ready-magic-zoom-quick-access-hdmi-e-usb-11458130.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 40" Full HD Samsung 40K5300 com Plataforma Tizen, Conectividade com Smartphones, Áudio Frontal, Conversor Digital, Wi-Fi, 2 HDMI e 1 USB</td>
                                                                                                <td>R$ 2.158,92</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>ou 12X de R$ 141,58 sem juros</td>
                                                                                                <td>Retira CasasBahia</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/tvseacessorios/Televisores/SmartTV/11314871/800799323/Smart-TV-LED-39-HD-Philco-PH39N91DSGWA-com-Wi-Fi-ApToide-Som-Surround-MidiaCast-Entradas-HDMI-e-USB-11314871.jpg" alt="Photo"></a></td>
                                                                                                <td>Smart TV LED 40" Full HD Samsung 40K5300 com Plataforma Tizen, Conectividade com Smartphones, Áudio Frontal, Conversor Digital, Wi-Fi, 2 HDMI e 1 USB</td>
                                                                                                <td>R$ 2.158,92</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>ou 12X de R$ 141,58 sem juros</td>
                                                                                                <td>Retira CasasBahia</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane" id="tab_search_6">
                                                                                    <div class="margin-bottom">
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <th style="width: 10px">#</th>
                                                                                                <th>Imagem</th>
                                                                                                <th>Produto</th>
                                                                                                <th>De</th>
                                                                                                <th>Por</th>
                                                                                                <th>Parc.</th>
                                                                                                <th>CTA</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Acimade10kg/3380807/45132095/Lavadora-de-Roupas-Electrolux-10-kg-LT10B-Turbo-Capacidade-e-Exclusiva-Tecla-Economia-3380806.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 10 kg LT10B Turbo Capacidade e Exclusiva Tecla Economia</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>R$ 1.349,00</td>
                                                                                                <td>ou 12X de R$ 91,58 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>2</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Acimade10kg/3986730/98330994/Lavadora-de-Roupas-Electrolux-15-kg-Turbo-Economia-LTD15-Branca-3986730.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 10 kg LT10B Turbo Capacidade e Exclusiva Tecla Economia</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>R$ 1.349,00</td>
                                                                                                <td>ou 12X de R$ 91,58 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>3</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Lavadorasde7kge9kg/3391377/155973559/Lavadora-de-Roupas-Consul-8-Kg-CWC08ABANA-Dispenser-Dose-Certa-Branca-3391377.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 10 kg LT10B Turbo Capacidade e Exclusiva Tecla Economia</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>R$ 1.349,00</td>
                                                                                                <td>ou 12X de R$ 91,58 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>4</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Acimade10kg/4060190/94235489/Lavadora-de-Roupas-Consul-10-Kg-Facilite-CWE10A-com-Dispenser-Flex-Branca-4060190.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 10 kg LT10B Turbo Capacidade e Exclusiva Tecla Economia</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>R$ 1.349,00</td>
                                                                                                <td>ou 12X de R$ 91,58 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>5</td>
                                                                                                <td><a href="#" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/Eletrodomesticos/maquinadelavar/Acimade10kg/3925053/833332519/Lavadora-de-Roupas-Electrolux-12-kg-Turbo-Capacidade-LT12B-3925053.jpg" alt="Photo"></a></td>
                                                                                                <td>Lavadora de Roupas Electrolux 10 kg LT10B Turbo Capacidade e Exclusiva Tecla Economia</td>
                                                                                                <td>R$ 1.699,00</td>
                                                                                                <td>R$ 1.349,00</td>
                                                                                                <td>ou 12X de R$ 91,58 sem juros</td>
                                                                                                <td>Entrega Super Expressa</td>
                                                                                            </tr>
                                                                                        </table>
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
                                                            <!-- /.tab-pane -->
                                                            <div class="tab-pane" id="tab_screenshots">
                                                                <a href="#" target="_blank"><img class="img-responsive" src="https://iprospectmonitor.com.br/dev/testes/_apagar/screenshot_sonar.jpg" alt="Photo"></a>
                                                            </div>
                                                            <!-- /.tab-pane -->
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
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- / MODAL -->


                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

    {!! Html::script('plugins/') !!}

    {{--<script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(function () {
            $('#scraps').DataTable({
                'paging'      : true,
                'searching'   : true,
                'ordering'    : true,
                "order"		: [[ 3, "desc" ]],
                "columnDefs"	: [
                    { targets: [4], orderable: false },
                    { targets: [5], orderable: false },
                ]
            });
            $("[data-tt=tooltip]").tooltip();
        });
    </script>--}}

@endsection