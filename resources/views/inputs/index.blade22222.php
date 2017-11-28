@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="row">
	<div class="col-md-12">
	  <ol class="breadcrumb hover" id="filtro_select">
		<li>{{$sessionBusca['nomePais']}}</li>
		<li>{{$sessionBusca['nomeLoja']}}</li>
		<li class="active">{{$sessionBusca['data']}}</li>
		<span class="right" style="float:right;">
			<i class="fa fa-filter"></i> Filter
		</span>
	  </ol>
	</div>
  </div>
</section>
  
<section class="content">
    <div class="box box-default" id="filtro">
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <form method="POST" action="/search">
                    {{ csrf_field() }}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::select('pais_id',$paises,null, ['placeholder' => 'All Countries', 'id'=>'country', 'class'=>'form-control countries select2'])!!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <select name="loja_id" id="loja_id" class="form-control countries select2" style="width:300px">
                                <option value="all">All Retailers</option>
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
                                <input class="form-control pull-right" name="data" id="period" type="text">
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
                                <button type="submit" class="btn btn-default btn-block" value="submit">OK</button>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </form>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <div class="row">
        <div class="col-md-12">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="box-title">Progress: <strong>{{$progresso}}%</strong></h3>
                    </div>
                    <div class="col-md-6">
                        <h3 class="box-title pull-right">
                            <strong>
                                <select class="form-control select2" name="scrap_id" id="scrap_id" tabindex="1">
                                   @if(!empty($scraps))
                                        <?php $i=1;?>
                                        @foreach($scraps as $value)
                                            <option value="{{ $value->id }}">{{$i}}(#{{ $value->id }})</option>
                                                <?php $i++;?>
                                        @endforeach
                                   @endif
                                </select>
                            </strong>
                            <strong>&nbsp; <?php if(!empty($totalScrapsAnalise)){ echo $totalScrapsAnalise; }?> </strong> records
                        </h3>
                    </div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: {{$progresso}}%"></div>
            </div>
        </div>
    </div>
    @if(session()->has('status'))
        <div class="alert alert-danger">
            {{session()->get('status')}}
        </div>
    @endif

    <!-- /.row -->
    @if($scrap)

        @if ($scrap->pais->pais == 'Brasil')
            <?php  $icon = "br";?>
        @elseif ($scrap->pais->pais == 'Argentina')
            <?php $icon = "ar";?>
        @elseif ($scrap->pais->pais == 'México')
            <?php $icon = "mx";?>
        @elseif ($scrap->pais->pais == 'Peru')
            <?php $icon = "pe";?>
        @elseif ($scrap->pais->pais == 'Chile')
            <?php $icon = "cl";?>
        @elseif ($scrap->pais->pais == 'Colômbia')
            <?php $icon = "co";?>
        @elseif ($scrap->pais->pais == 'Sela')
            <?php $icon = "pa";?>
        @endif

    @else
        <?php  $icon = "br";?>
    @endif

    <?php
        $countProgress = 0;
        $array[] = $scrap;
        foreach( $array as $value){
          $dados = explode(":", $value);
           foreach ($dados as $dado){
              if(!empty($dado)) {
                  $countProgress++;
              }
           }

        }
    ?>

    <?php if($scrap) {?>
    <div class="box box-solid" id="panel-fullscreen">
        {!! Form::open(['url' => 'inputs/update', 'method' => 'post']) !!}
        <input type="hidden" name="id" id="id" value="@if($scrap){{ $scrap->id }} @endif" >
        <input type="hidden" name="usuario_id" value="{{Auth::user()->id}}" >
        <div class="box-header with-border">
				<div class="row">
					<div class="col-md-2">
						<div class="btn-group">
							<button type="button" value="{{$scrap->id-1}}" class="btn btn-default btn-flat" id="scrapIdPaginacao1"><i class="fa fa-angle-left"></i></button>
							<button type="button" value="{{$scrap->id}}" style="padding-left:3px;padding-right:3px;" class="btn btn-default btn-flat disabled" id="scrapIdPaginacao">#{{$scrap->id}}</button>
							<button type="button" value="{{$scrap->id+1}}" class="btn btn-default btn-flat" id="scrapIdPaginacao2"><i class="fa fa-angle-right"></i></button>
							<br /><small style="font-size:12px;"><div id="datescrap">{{$scrap->created_at}}</div></small>
						</div>					
					</div>
					<div class="col-md-10">				
							<div class="box-tools pull-right">
								<button type="button" style="z-index: 9999" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								&nbsp;
								<button type="button" style="z-index: 9999" class="btn btn-box-tool" id="panel-actions" title="Fullscreen"><i class="glyphicon glyphicon-resize-full"></i></button>
							</div>					
							<p>Progress: <strong>{{$countProgress}}%</strong></p>
							<div class="progress progress-xxs">
								<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$countProgress}}%"></div>
							</div>				  
					</div>				
				</div>
        </div>
        <div class="box-body">

            <div class="col-md-2">

                <div class="row">

                    <!-- /.col -->
                    <div class="col-md-12">
                        <a href="#" data-toggle="modal" data-target="#modal-ver" data-backdrop="static" data-keyboard="false" target="_blank"><img class="img-responsive img-popover" src="{{$scrap->arquivo}}" alt="" id="imagem" ></a>
                        <br />
                        <div class="bg-gray-light box collapsed-box box-solid"><div class="box-header with-border"><span class="flag-icon flag-icon-left flag-icon-{{$icon}}"></span><a href="javascript:void(0);" id="pais_id">{{$scrap->pais->pais}}</a></div></div>
                        <div class="bg-gray-light box collapsed-box box-solid"><div class="box-header with-border"><span><img src="https://www.google.com/s2/favicons?domain=http://{{$scrap->loja->url}}" class="favicon-left" id="lojaUrl"><a href="javascript:void(0);" id="lojaid">{{$scrap->loja->descricao}}</a><i class="fa fa-external-link right"></i></span></div></div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.col -->
            <div class="col-md-10">

                <div class="row">
                    <div class="col-md-2">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Device</label>
                            <select class="form-control" name="device" id="device" style="width: 100%;" tabindex="1">
                                <option value="Mobile" <?php if($scrap->device=='Mobile'){ echo 'selected'; }?>>Mobile</option>
                                <option value="Desktop" <?php if($scrap->device=='Desktop'){ echo 'selected'; }?>>Desktop</option>
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Page Type</label>
                            <select class="form-control" name="tipo_pagina" style="width: 100%;" tabindex="2">
                              {{--  @if($scrap->tipo_pagina==0) <option value=0  selected>Other</option> @endif--}}
                                @foreach($tipoPagina as $value)
                                    <option value="{{$value->id}}" <?php if($scrap->tipo_pagina_id==$value->id){ echo 'selected';}?>>{{$value->tipo_pagina}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Place</label>
                            <select  name="tipo_anuncio" class="form-control" style="width: 100%;" tabindex="3">
                                @if($scrap->tipo_anuncio_id==0) <option value=0  selected>Other</option> @endif
                                @foreach($tipoAnuncio as $value) {
                                    <option value="{{$value->id}}" <?php if($scrap->tipo_anuncio_id==$value->id){ echo 'selected';}?>>{{$value->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-2">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Position</label>
                            <select class="form-control" name="position" id="position" style="width: 100%;" tabindex="4">
                                <?php for($i=1; $i<=50; $i++){ ?>
                                <option <?php if($scrap->position==$i){ echo 'selected';}?>>{{$i}}<option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
						<div class="form-group">
                            <label>Target URL</label>
                            <input class="form-control" id="url" placeholder="Target URL" name="target" type="text" value="@if($scrap){{$scrap->target}}@endif"  tabindex="5">
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" style="width: 100%;" tabindex="6" name="type">
                                @foreach($tipoPagina as $value)
                                    <option value="{{$value->id}}"  @if($scrap){{$scrap->id==$value->id ? 'selected':'selected' }} @endif>{{$value->tipo_pagina}}</option>
                                @endforeach
                            </select>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Category</label>
                            <select name="categoria_id" id="categoria_id" class="form-control" style="width: 100%;" tabindex="7">
                                @if($scrap->categoria_id==0) <option value=0  selected>0 - Other</option> @endif
                                @foreach($categorias as $value) {
									<option value="{{ $value->id }}" @if($scrap->categoria_id==$value->id) 'selected' @endif>{{ $value->id }} - {{$value->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Brand</label>
                            <select class="form-control" name="marca_id" id="marca_id"  style="width: 100%;" tabindex="8">
                                @if($scrap->marca_id==0) <option value=0  selected>0 - Other</option> @endif
                                @foreach($marcas as $value)
                                    <option value="{{ $value->id }}" <?php if($scrap->marca_id==$value->id){ echo 'selected';}?>>{{ $value->id }} - {{$value->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product</label>
                            <input class="form-control" id="product" name="produto" placeholder="Nome do produto" type="text" value="@if($scrap){{$scrap->produto}}@endif" tabindex="9">
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input class="form-control" id="title" name="titulo" placeholder="Título do produto" type="text" value="@if($scrap){{$scrap->titulo}}@endif" tabindex="10">
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Detail</label>
                            <input class="form-control" id="detail" name="detalhe" placeholder="Descrição mais detalhada do produto" type="text" value="@if($scrap){{$scrap->detalhe}}@endif" tabindex="11">
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Call to Action</label>
                            <input class="form-control" id="cta" name="call_action" placeholder="Frete Grátis" type="text" value="@if($scrap){{$scrap->detalhe}}@endif" tabindex="12">
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <label>Price</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                <input class="form-control" name="preco" id="preco" placeholder="8.888,88" type="text" value="@if($scrap){{$scrap->preco}}@endif" tabindex="13">
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Price From</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                <input class="form-control"name="price_from" id="price_from" placeholder="9.999,99" type="text" value="@if($scrap){{$scrap->price_from}}@endif" tabindex="14">
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Price Install</label>
                            <input class="form-control" name="price_install" id="price_install" placeholder="ou 6X de R$ 18,32 sem juros" type="text" value="@if($scrap){{$scrap->price_install}}@endif" tabindex="15">
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Ad Type</label>
                            <select class="form-control" name="adType" id="adType" style="width: 100%;" tabindex="16">
                                @if($scrap->tipo_anuncio_id==0) <option value=0  selected>Other</option> @endif
                                @foreach($tipoAnuncio as $value) {
                                <option value="{{$value->id}}" <?php if($scrap->tipo_anuncio_id==$value->id){ echo 'selected';}?>>{{$value->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ad Type Detail</label>
                            <input class="form-control" name="ad_type_detail" id="adtypedetail" placeholder="5% Off" type="text" value="@if($scrap){{$scrap->detalhe_tipo_anuncio}}@endif" tabindex="17">
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">&nbsp;</div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-2">
                        <div class="form-group pull-right btn-block">
                            <button class="btn btn-danger btn-lg btn-block" name="descartar" value="descartar" tabindex="18" type="submit">Descartar</button>
                        </div>
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                    <div class="col-md-2">
                        <div class="form-group pull-right btn-block">
                            <button class="btn btn-success btn-lg btn-block" name="submit" value="enviar" tabindex="18" type="submit">Salvar</button>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.box-body -->

    </div stype=>
    <!-- /.box -->
    <?php } ?>

</section>
<!-- /.content -->
	
@section('pagescript')
    <script src="{{ asset('/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/plugins/select2.full.min.js')}}"></script>
    <script src="{{ asset('/plugins/inputmask/dist/inputmask/inputmask.js')}}"></script>
    <script src="{{ asset('/plugins/inputmask/dist/inputmask/inputmask.date.extensions.js')}}"></script>
    <script src="{{ asset('/plugins/inputmask/dist/inputmask/inputmask.extensions.js')}}"></script>
    <script src="{{ asset('/plugins/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
	$(document).ready(function(){
		
		//FOCO AUTOMÁTICO NO 1º CAMPO
		$('#device').focus()
		//$("form:not(.filter) :input:visible:enabled:first").focus();


        $('#scrapIdPaginacao1').click(function () {
            //var scrap_id = $(this).val();
            var scrap_id =  $("#scrapIdPaginacao").text()-1;
            var id =  $("input[name='id']");
            var target  = $("input[name='target']");
            var produto = $("input[name='produto']");
            var titulo = $("input[name='titulo']");
            var detalhe = $("input[name='detalhe']");
            var call_action = $("input[name='call_action']");
            var price_install = $("input[name='price_install']");
            var price_from = $("input[name='price_from']");
            var preco = $("input[name='preco']");

            $.ajax({
                type: "POST",
                url: "inputs",
                data: "scrap_id=" + scrap_id,
                processData: true,
                dateType:'json',
                cache: false,
                success: function (data) {
                    $("#id").val("");
                    $("#scrapIdPaginacao").val("");
                    $("#imagem").attr('src', "");
                    $("#lojaUrl").attr('src', "");
                    $("#device").val("");
                    $("#position").val("");
                    $("#tipo_pagina").val("");
                    $("#tipo_anuncio").val("");
                    $("#categoria_id").val("");
                    $("#marca_id").val("");
                    $("#adType").val("");
                    $("#ad_type_detail").val("");
                    $("#datescrap").html("");
                    $("#pais_id").html("");
                    titulo.val("");
                    target.val("");
                    produto.val("");
                    detalhe.val("");
                    call_action.val("");
                    call_action.val("");
                    preco.val("");
                    price_from.val("");
                    price_install.val("");
                    $("#lojaUrl").attr('src', "");


                    var dados =  JSON.parse(data);


                    $("#id").val(dados.id);
                    $("#imagem").attr('src', dados.arquivo);
                    $("#device").val(dados.device);
                    $("#position").val(dados.position);
                    $("#tipo_pagina").val(dados.tipo_pagina_id);
                    $("#tipo_anuncio").val(dados.tipo_anuncio);
                    $("#categoria_id").val(dados.categoria_id);
                    $("#marca_id").val(dados.marca_id);
                    $("#adType").val(dados.ad_type);
                    $("#ad_type_detail").val(dados.ad_type_detail);
                    titulo.val(dados.titulo);
                    target.val(dados.target);
                    produto.val(dados.produto);
                    detalhe.val(dados.detalhe);
                    call_action.val("");
                    call_action.val(dados.call_action);
                    preco.val(dados.preco);
                    price_from.val(dados.price_from);
                    price_install.val(dados.price_install);
                    datescrap.append(dados.updated_at);
                    $("#pais_id").html(dados.pais_id);
                    $("#lojaid").html(dados.loja_id);
                    $("#lojaUrl").attr('src', dados.url);
                    $("#scrapIdPaginacao").html(dados.id);


                    $('.form-control').each(function(e,i){
                        if(this.value.trim() === ""){
                            $(this).parent().addClass('has-warning');
                        } else {
                            $(this).parent().removeClass('has-warning');
                        }
                    });
                }

            });
        });

        $('#scrapIdPaginacao2').click(function () {
            var scrap_id =  parseInt($("#scrapIdPaginacao").text()) + parseInt(1);
            var id =  $("input[name='id']");
            var target  = $("input[name='target']");
            var produto = $("input[name='produto']");
            var titulo = $("input[name='titulo']");
            var detalhe = $("input[name='detalhe']");
            var call_action = $("input[name='call_action']");
            var price_install = $("input[name='price_install']");
            var price_from = $("input[name='price_from']");
            var preco = $("input[name='preco']");

            $.ajax({
                type: "POST",
                url: "inputs",
                data: "scrap_id=" + scrap_id,
                processData: true,
                dateType:'json',
                cache: false,
                success: function (data) {
                    $("#id").val("");
                    $("#scrapIdPaginacao").val("");
                    $("#imagem").attr('src', "");
                    $("#lojaUrl").attr('src', "");
                    $("#device").val("");
                    $("#position").val("");
                    $("#tipo_pagina").val("");
                    $("#tipo_anuncio").val("");
                    $("#categoria_id").val("");
                    $("#marca_id").val("");
                    $("#adType").val("");
                    $("#ad_type_detail").val("");
                    $("#datescrap").html("");
                    $("#pais_id").html("");
                    titulo.val("");
                    target.val("");
                    produto.val("");
                    detalhe.val("");
                    call_action.val("");
                    call_action.val("");
                    preco.val("");
                    price_from.val("");
                    price_install.val("");
                    $("#lojaUrl").attr('src', "");


                    var dados =  JSON.parse(data);


                    $("#id").val(dados.id);
                    $("#imagem").attr('src', dados.arquivo);
                    $("#device").val(dados.device);
                    $("#position").val(dados.position);
                    $("#tipo_pagina").val(dados.tipo_pagina_id);
                    $("#tipo_anuncio").val(dados.tipo_anuncio);
                    $("#categoria_id").val(dados.categoria_id);
                    $("#marca_id").val(dados.marca_id);
                    $("#adType").val(dados.ad_type);
                    $("#ad_type_detail").val(dados.ad_type_detail);
                    titulo.val(dados.titulo);
                    target.val(dados.target);
                    produto.val(dados.produto);
                    detalhe.val(dados.detalhe);
                    call_action.val("");
                    call_action.val(dados.call_action);
                    preco.val(dados.preco);
                    price_from.val(dados.price_from);
                    price_install.val(dados.price_install);
                    datescrap.append(dados.updated_at);
                    $("#pais_id").html(dados.pais_id);
                    $("#lojaid").html(dados.loja_id);
                    $("#lojaUrl").attr('src', dados.url);
                    $("#scrapIdPaginacao").html(dados.id);


                    $('.form-control').each(function(e,i){
                        if(this.value.trim() === ""){
                            $(this).parent().addClass('has-warning');
                        } else {
                            $(this).parent().removeClass('has-warning');
                        }
                    });
                }

            });
        });


		
		$('#scrap_id,.scrap_id').change(function() {
			var scrap_id = $(this).val();
			var id =  $("input[name='id']");
			var target  = $("input[name='target']");
			var produto = $("input[name='produto']");
			var titulo = $("input[name='titulo']");
			var detalhe = $("input[name='detalhe']");
			var call_action = $("input[name='call_action']");
			var price_install = $("input[name='price_install']");
			var price_from = $("input[name='price_from']");
			var preco = $("input[name='preco']");

			$.ajax({
				type: "POST",
				url: "inputs",
				data: "scrap_id=" + scrap_id,
				processData: true,
				dateType:'json',
				cache: false,
				success: function (data) {
                    $("#id").val("");
                    $("#scrapIdPaginacao").val("");
                    $("#imagem").attr('src', "");
                    $("#lojaUrl").attr('src', "");
                    $("#device").val("");
                    $("#position").val("");
                    $("#tipo_pagina").val("");
                    $("#tipo_anuncio").val("");
                    $("#categoria_id").val("");
                    $("#marca_id").val("");
                    $("#adType").val("");
                    $("#ad_type_detail").val("");
                    $("#datescrap").html("");
                    $("#pais_id").html("");
                    titulo.val("");
                    target.val("");
                    produto.val("");
                    detalhe.val("");
                    call_action.val("");
                    call_action.val("");
                    preco.val("");
                    price_from.val("");
                    price_install.val("");
                    $("#lojaUrl").attr('src', "");


					var dados =  JSON.parse(data);


					$("#id").val(dados.id);
					$("#imagem").attr('src', dados.arquivo);
					$("#device").val(dados.device);
					$("#position").val(dados.position);
					$("#tipo_pagina").val(dados.tipo_pagina_id);
					$("#tipo_anuncio").val(dados.tipo_anuncio);
					$("#categoria_id").val(dados.categoria_id);
					$("#marca_id").val(dados.marca_id);
					$("#adType").val(dados.ad_type);
					$("#ad_type_detail").val(dados.ad_type_detail);
					titulo.val(dados.titulo);
					target.val(dados.target);
					produto.val(dados.produto);
					detalhe.val(dados.detalhe);
                    call_action.val("");
					call_action.val(dados.call_action);
					preco.val(dados.preco);
					price_from.val(dados.price_from);
					price_install.val(dados.price_install);
                    datescrap.append(dados.updated_at);
                    $("#pais_id").html(dados.pais_id);
                    $("#lojaid").html(dados.loja_id);
                    $("#lojaUrl").attr('src', dados.url);
                    $("#scrapIdPaginacao").html(dados.id);


                    $('.form-control').each(function(e,i){
                        if(this.value.trim() === ""){
                            $(this).parent().addClass('has-warning');
                        } else {
                            $(this).parent().removeClass('has-warning');
                        }
                    });
				}

			});
		});
				
		setTimeout(function(){
			$("div.alert").remove();
		}, 5000 ); // 5 secs
				
		// Hide/Show Filter
		jQuery("#filtro").hide();
		jQuery("#filtro_select").show();
		jQuery("#filtro_select").click(function(){
		  jQuery("#filtro").slideToggle();
		});
		jQuery('.hideMe').click(function(){
		  jQuery(this).parent().slideUp();
		});					
				
		// Fulscreen button
		jQuery('#panel-actions').click(function(e){
			var $this = $(this);
			if ($this.children('i').hasClass('glyphicon-resize-full')) {
				$this.children('i').removeClass('glyphicon-resize-full');
				$this.children('i').addClass('glyphicon-resize-small');
			} else if ($this.children('i').hasClass('glyphicon-resize-small')) {
				$this.children('i').removeClass('glyphicon-resize-small');
				$this.children('i').addClass('glyphicon-resize-full');
			}      
			jQuery('#panel-fullscreen').toggleClass('panel-fullscreen'); 
		});
					
		//Date range picker
		$('#period').daterangepicker({
			ranges   : {
			  'Today'       : [moment(), moment()],
			  'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			  'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
			  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			  'This Month'  : [moment().startOf('month'), moment().endOf('month')],
			  'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			startDate: moment().subtract(29, 'days'),
			endDate  : moment(),
			autoclose: true
		  },
		  function (start, end) {
			$('#period span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
		  }
		)
		
		//POPOVER
		jQuery('.img-popover').popover({
		  html: true,
		  trigger: 'hover',
		  placement: 'auto left',
		  content: function () {
			return '<img src="'+$(this).attr('src') + '" width="auto" height="auto" style="max-width:600px;" />';
		  }
		 });	
		
		$("body").addClass("sidebar-collapse");
		


   /*     $("#loja_id").val({{Session::get('lojaID')}});
        //$( "select#loja_id" ).val({{Session::get('lojaID')}});
		$("#period").val({{Session::get('dataID')}});*/

        $('.form-control').each(function(e,i){
            if(this.value.trim() === ""){
                $(this).parent().addClass('has-warning');
            } else {
                $(this).parent().removeClass('has-warning');
            }
        });

		
	});
	
	$('#country').change(function(){
		var countryID = $(this).val();
		if(countryID){
			$.ajax({
				type:"GET",
				url:"{{url('inputs/get-loja-list')}}?country_id="+countryID,
				success:function(res){
					if(res){
						$("#loja_id").empty();
						$("#loja_id").append('<option>All Retailers</option>');
						$.each(res,function(key,value){
							$("#loja_id").append('<option value="'+key+'">'+value+'</option>');
						});

					}else{
					    $("#loja_id").empty();

					}
				}
			});
		}else{
		        $("#loja_id").empty();
		}
	});

    if('#country' != null){
        $("#country").val({{$sessionBusca['pais']}});
        var countryID =  JSON.parse({{$sessionBusca['pais']}});
        var lojaID = JSON.parse({{$sessionBusca['loja']}});
        $.ajax({
            type:"GET",
            url:"{{url('inputs/get-loja-list')}}?country_id="+countryID,
            success:function(res){
                if(res){
                    $("#loja_id").empty();
                    $("#loja_id").append('<option>All Retailers</option>');
                    $.each(res,function(key,value){
                        if(lojaID==key){
                            $("#loja_id").append('<option value="'+key+'" selected>'+value+'</option>');
                        }else {
                            $("#loja_id").append('<option value="'+key+'">'+value+'</option>');
                        }

                    });

                }else{
                    $("#loja_id").empty();

                }
            }
        });
    }

	$(document).ready(function(){
		//Initialize Select2 Elements
		//jQuery('.select2').select2()
		jQuery('.select2').select2().enable(false);
	});
</script>

@stop

@endsection
