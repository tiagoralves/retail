@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')

    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
	
      <!-- SELECT2 EXAMPLE -->
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
                  <option selected="selected">Brasil</option>
                  <option>Alaska</option>
                  <option>California</option>
                  <option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>
                </select>
              </div>
            </div>			  
            <div class="col-md-4">
              <!-- /.form-group -->
              <div class="form-group">
                <select class="form-control select2" style="width: 100%;">
                  <option selected="selected">Casas Bahia</option>
                  <option>Alaska</option>
                  <option>California</option>
                  <option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>
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
                  <input class="form-control pull-right" id="reservation" type="text">
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
      <!-- /.box -->
	  
          <div class="row">
            <div class="col-md-12">
				<div class="box-header with-border">
					<div class="row">
						<div class="col-md-6">
							<h3 class="box-title">Progress: <strong>45%</strong></h3>
						</div>
						<div class="col-md-6">
							<h3 class="box-title pull-right">
							<strong>
							<select class="form-control select2" tabindex="1">
							  <option selected="selected">333</option>
							  <option>334</option>
							  <option>335</option>
							  <option>336</option>
							  <option>337</option>
							  <option>338</option>
							  <option>339</option>
							  <option>340</option>
							  <option>...</option>
							</select>
							</strong>&nbsp; of 
							<strong>&nbsp; 999 </strong> records
							</h3>
						</div>
					</div>
				</div>
				<div class="progress">
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%"></div>
				</div>			
			</div>
		  </div>			
          <!-- /.row -->

          <div class="box box-solid">
	  
            <div class="box-header with-border">
			
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			
				<p>Progresso: <strong>65%</strong></p>
				<div class="progress progress-xxs">
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 65%"></div>
				</div>
			  
			</div>
			
            <div class="box-body">
			
				<div class="col-md-2">
				
						<div class="row">

							<!-- /.col -->					
							<div class="col-md-12">
								<a href="#" data-toggle="modal" data-target="#modal-ver" data-backdrop="static" data-keyboard="false" target="_blank"><img class="img-responsive" src="http://www.casasbahia-imagens.com.br/html/2017/banner-mosaico/2017-08-25/home-mosaico-1.png" alt="Photo"></a>
								<br />
								<div class="bg-gray-light box collapsed-box box-solid"><div class="box-header with-border"><span class="flag-icon flag-icon-left flag-icon-br"></span><a href="#">Brasil</a></div></div>
								<div class="bg-gray-light box collapsed-box box-solid"><div class="box-header with-border"><span><img src="https://www.google.com/s2/favicons?domain=http://www.casasbahia.com.br/" class="favicon-left"><a href="#">Casas Bahia</a><i class="fa fa-external-link right"></i></a></span></div></div>						
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
						<select class="form-control select2" style="width: 100%;" tabindex="1">
						  <option selected="selected">Mobile</option>
						  <option>Desktop</option>
						</select>
					  </div>
					  <!-- /.form-group -->
					</div>
					<!-- /.col -->
					<div class="col-md-4">
					  <div class="form-group">
						<label>Page Type</label>
						<select class="form-control select2" style="width: 100%;" tabindex="2">
						  <option selected="selected">Homepage</option>
						  <option>Category</option>
						  <option>Search</option>
						</select>
					  </div>
					</div>
					<!-- /.col -->					
					<div class="col-md-4">
					  <!-- /.form-group -->
					  <div class="form-group">
						<label>Place</label>
						<select class="form-control select2" style="width: 100%;" tabindex="3">
						  <option selected="selected">Ads</option>
						  <option>Carousel</option>
						  <option>Organic</option>
						  <option>Keyword</option>
						</select>
					  </div>
					  <!-- /.form-group -->
					</div>
					<!-- /.col -->
					<div class="col-md-2">
					  <!-- /.form-group -->
					  <div class="form-group">
						<label>Position</label>
						<select class="form-control select2" style="width: 100%;" tabindex="4">
						  <option selected="selected">1</option>
						  <option>2</option>
						  <option>3</option>
						  <option>4</option>
						  <option>5</option>
						  <option>6</option>
						  <option>7</option>
						  <option>8</option>
						  <option>9</option>
						  <option>10</option>
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
						<input class="form-control" id="exampleInputEmail1" placeholder="Target URL" type="text" value="http://www.casasbahia.com.br/?Filtro=D21661&Ordenacao=_MaisVendidos&icid=177962_hp_stc_c2_ps1_b0_pb1"  tabindex="5">
					  </div>
					</div>
					<!-- /.col -->
					</div>
					<!-- /.row -->

					<div class="row">
					<div class="col-md-4">
					  <div class="form-group">
						<label>Type</label>
						<select class="form-control select2" style="width: 100%;" tabindex="6">
						  <option selected="selected">Homepage</option>
						  <option>Category</option>
						  <option>Search</option>
						</select>
					  </div>
					</div>			  
					<div class="col-md-4">
					  <!-- /.form-group -->
					  <div class="form-group">
						<label>Category</label>
						<select class="form-control select2" style="width: 100%;" tabindex="7">
						  <option selected="selected">Ads</option>
						  <option>Carousel</option>
						  <option>Organic</option>
						  <option>Keyword</option>
						</select>
					  </div>
					  <!-- /.form-group -->
					</div>
					<!-- /.col -->
					<div class="col-md-4">
					  <!-- /.form-group -->
					  <div class="form-group">
						<label>Brand</label>
						<select class="form-control select2" style="width: 100%;" tabindex="8">
						  <option selected="selected">Consul</option>
						  <option>LG</option>
						  <option>Brastemp</option>
						  <option>GE</option>
						  <option>Samsung</option>
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
						<input class="form-control" id="exampleInputEmail1" placeholder="Nome do produto" type="text" value="Lavadora de Roupas Consul Inverter WD-LZ109SAR1" tabindex="9">
					  </div>
					</div>
					<!-- /.col -->
					<div class="col-md-6">
					  <div class="form-group">
						<label>Title</label>
						<input class="form-control" id="exampleInputEmail1" placeholder="Título do produto" type="text" value="Lavadora Consul Inverter" tabindex="10">
					  </div>
					</div>
					<!-- /.col -->				
					</div>
					<!-- /.row -->				
					
					<div class="row">
					<div class="col-md-8">
					  <div class="form-group">
						<label>Detail</label>
						<input class="form-control" id="exampleInputEmail1" placeholder="Descrição mais detalhada do produto" type="text" value="Lavadora de Roupas Inverter Carga Frontal 8.8 Kg LG F1400PD Branca" tabindex="11">
					  </div>
					</div>
					<!-- /.col -->
					<div class="col-md-4">
					  <div class="form-group">
						<label>Call to Action</label>
						<input class="form-control" id="exampleInputEmail1" placeholder="Frete Grátis" type="text" value="Frete Grátis" tabindex="12">
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
							<input class="form-control" placeholder="8.888,88" type="text" value="8.888,88" tabindex="13">
						</div>				
					  </div>
					</div>
					<!-- /.col -->
					<div class="col-md-2">
					  <div class="form-group">
						<label>Price From</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input class="form-control" placeholder="9.999,99" type="text" value="9.999,99" tabindex="14">
						</div>	
					  </div>
					</div>
					<!-- /.col -->
					<div class="col-md-3">
					  <div class="form-group">
						<label>Price Install</label>
						<input class="form-control" id="exampleInputEmail1" placeholder="Target URL" type="text" value="em até 12x de R$ 740,74 s/ juros" tabindex="15">
					  </div>
					</div>
					<!-- /.col -->
					<div class="col-md-2">
					  <div class="form-group">
						<label>Ad Type</label>
						<select class="form-control select2" style="width: 100%;" tabindex="16">
						  <option selected="selected">Discount</option>
						  <option>Display</option>
						  <option>Bundle</option>
						  <option>Launch</option>
						</select>
					  </div>
					</div>
					<!-- /.col -->
					<div class="col-md-3">
					  <div class="form-group">
						<label>Ad Type Detail</label>
						<input class="form-control" id="exampleInputEmail1" placeholder="5% Off" type="text" value="40% Off" tabindex="17">
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
					<div class="col-md-10">
					  <div class="input-group">
					  </div>
					</div>
					<!-- /.col -->
					<div class="col-md-2">
					  <div class="form-group pull-right btn-block">
						  <button class="btn btn-default btn-lg btn-block" tabindex="18">Salvar</button>
					  </div>
					</div>
					<!-- /.col -->					
					</div>
					<!-- /.row -->						

				</div>
				<!-- /.col -->
            </div>
            <!-- /.box-body -->
						
          </div>
          <!-- /.box --> 
		
    @include('adminlte::layouts.partials.scripts_inputs')

@endsection
