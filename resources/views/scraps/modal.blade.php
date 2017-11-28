@extends('adminlte::layouts.modal')

    <!-- Main content -->
    <section>
        <div>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title"><img src="https://www.google.com/s2/favicons?domain={{$loja->url}}" class="favicon-left">{{$loja->descricao}} - {{$device}} - {{date('d/m/Y', strtotime($data))}}</h4>
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
                                                                  @foreach($home  as $value)
                                                                        <tr>
                                                                            <td>{{$value->position}}</td>
                                                                            <td><a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioImportio.$value->arquivo}}" alt="Photo"></a></td>
                                                                            <td>{{$value->titulo}}</td>
                                                                            <td>{{$value->preco}}</td>
                                                                            <td>{{$value->preco_promocao}}</td>
                                                                            <td>{{$value->preco_inicial}}</td>
                                                                            <td>{{ $value->call_action }}</td>
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
                                                                    @foreach($carrossel  as $value)
                                                                        <tr>
                                                                            <td>{{$value->position}}</td>
                                                                            <td><a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioImportio.$value->arquivo}}" alt="Photo"></a></td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="tab_homepage_ads">
                                                            <div class="margin-bottom">
                                                                <div class="gal">
                                                                  @foreach($ads  as $value)
                                                                        <a href="#" target="_blank"><img class="img-responsive img-bordered2" src="{{$diretorioImportio.$value->arquivo}}" alt="Photo"></a>
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
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_category">
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- tabs up -->
                                                <div class="tabs-up">
                                                    <ul class="nav nav-tabs nav-tabs-btn">
                                                        <li class="active"><a href="#tab_category_1" data-toggle="tab">Smartphones</a></li>
                                                        <li><a href="#tab_category_2" data-toggle="tab">Refrigerators</a></li>
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
                                                                  @foreach($smartfones  as $value)
                                                                    <tr>
                                                                        <td>{{ $value->position }}</td>
                                                                        <td><a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioImportio.$value->arquivo}}" alt="Photo"></a></td>
                                                                        <td>{{ $value->titulo }}</td>
                                                                        <td>{{ $value->preco }}</td>
                                                                        <td>{{ $value->preco_promocao }}</td>
                                                                        <td>{{ $value->call_action }}</td>
                                                                        <td>Entrega Expressa</td>
                                                                    </tr>
                                                                   @endforeach
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
                                                                    @foreach($geladeiras as $value)
                                                                        <tr>
                                                                            <td>{{ $value->position }}</td>
                                                                            <td><a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioImportio.$value->arquivo}}" alt="Photo"></a></td>
                                                                            <td>{{ $value->titulo }}</td>
                                                                            <td>{{ $value->preco }}</td>
                                                                            <td>{{ $value->preco_promocao }}</td>
                                                                            <td>{{ $value->call_action }}</td>
                                                                            <td>Entrega Expressa</td>
                                                                        </tr>
                                                                    @endforeach

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
                                                                    @foreach($tvs as $value)
                                                                        <tr>
                                                                            <td>{{ $value->position }}</td>
                                                                            <td><a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioImportio.$value->arquivo}}" alt="Photo"></a></td>
                                                                            <td>{{ $value->titulo }}</td>
                                                                            <td>{{ $value->preco }}</td>
                                                                            <td>{{ $value->preco_promocao }}</td>
                                                                            <td>{{ $value->call_action }}</td>
                                                                            <td>Entrega Expressa</td>
                                                                        </tr>
                                                                  @endforeach
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
                                                                   @foreach($maquinadelavar as $value)
                                                                        <tr>
                                                                            <td>{{ $value->position }}</td>
                                                                            <td><a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioImportio.$value->arquivo}}" alt="Photo"></a></td>
                                                                            <td>{{ $value->titulo }}</td>
                                                                            <td>{{ $value->preco }}</td>
                                                                            <td>{{ $value->preco_promocao }}</td>
                                                                            <td>{{ $value->call_action }}</td>
                                                                            <td>Entrega Expressa</td>
                                                                        </tr>
                                                                    @endforeach

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
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- tabs up -->
                                                <div class="tabs-up">
                                                    <ul class="nav nav-tabs nav-tabs-btn">
                                                        <li class="active"><a href="#tab_screen_1" data-toggle="tab"><i class="fa fa-file-picture-o left"></i>Homepage</a></li>
                                                        <li><a href="#tab_screen_2" data-toggle="tab"><i class="fa fa-file-picture-o left"></i>TV</a></li>
                                                        <li><a href="#tab_screen_3" data-toggle="tab"><i class="fa fa-file-picture-o left"></i>Washing Machine</a></li>
                                                        <li><a href="#tab_screen_4" data-toggle="tab"><i class="fa fa-file-picture-o left"></i>Refrigerator</a></li>
                                                        <li><a href="#tab_screen_5" data-toggle="tab"><i class="fa fa-file-picture-o left"></i>Smartphone</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab_screen_1">
                                                            <div class="margin-bottom">
                                                                <a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioUrlbox.$screenshotsHome->arquivo}}" alt="Photo" /></a>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="tab_screen_2">
                                                            <div class="margin-bottom">
                                                                <a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioUrlbox.$screenshotsTv->arquivo}}" alt="Photo"></a>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="tab_screen_3">
                                                            <div class="margin-bottom">
                                                                <a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioUrlbox.$screenshotsWashing->arquivo}}" alt="Photo"></a>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="tab_screen_4">
                                                            <div class="margin-bottom">
                                                                <a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioUrlbox.$screenshotsRefrigerators->arquivo}}" alt="Photo"></a>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="tab_screen_5">
                                                            <div class="margin-bottom">
                                                                <a href="#" target="_blank"><img class="img-responsive" src="{{$diretorioUrlbox.$screenshotsSmartphones->arquivo}}" alt="Photo"></a>
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

                </div>
            </div>
        </div>

    </section>
    <!-- Main content -->

