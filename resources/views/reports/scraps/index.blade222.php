@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
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
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                                <?php

                                        $dataCron = date('Y-m-d', strtotime($value->created_at));
                                        $dataAtual = date('Y-m-d');
                                        $time = time();
                                        $cronHoraInicio1 = strtotime('03:00:00');
                                        $cronHoraFinal1 = strtotime('10:59:59');

                                        $cronHoraInicio2 = strtotime('11:00:00');
                                        $cronHoraFinal2 = strtotime('18:59:59');

                                        $cronHoraInicio3 = strtotime('19:00:00');
                                        $cronHoraFinal3 = strtotime('23:59:00');


                                        $hora1 = strtotime($value->loja->hora1);
                                        $hora2 = strtotime($value->loja->hora2);
                                        $hora3 = strtotime($value->loja->hora3);

                                        if( $time >= $cronHoraInicio1 && $time <= $cronHoraFinal1 && strtotime($dataAtual) == strtotime($dataCron)) {
                                            $turno1 = 'bg-tea';
                                            $turno2 =  "bg-orange-fail";
                                            $turno3 = "bg-gray-fail";
                                        } elseif($time >= $cronHoraInicio2 && $time <= $cronHoraFinal2  && strtotime($dataAtual) == strtotime($dataCron)) {
                                            $turno1 = 'bg-teal';
                                            $turno2 =  "bg-orange";
                                            $turno3 = "bg-gray";
                                        } elseif ($time >= $cronHoraInicio3 && $time <= $cronHoraFinal3 || strtotime($dataAtual) > strtotime($dataCron)) {
                                            $turno1 = 'bg-teal';
                                            $turno2 =  "bg-orange";
                                            $turno3 = "bg-navy";
                                        }

                                ?>

                                @if ($value->pais->pais == 'Brasil')
                                    <?php  $icon = "br";?>
                                @elseif ($value->pais->pais == 'Argentina')
                                    <?php $icon = "ar";?>
                                @elseif ($value->pais->pais == 'México')
                                    <?php $icon = "mx";?>
                                @elseif ($value->pais->pais == 'Peru')
                                    <?php $icon = "pe";?>
                                @elseif ($value->pais->pais == 'Chile')
                                    <?php $icon = "cl";?>
                                @elseif ($value->pais->pais == 'Colômbia')
                                       <?php $icon = "co";?>
                                @elseif ($value->pais->pais == 'Sela')
                                    <?php $icon = "pa";?>
                                @endif

                                <tr>
                                    <td class="visible-md visible-lg"><span class="flag-icon flag-icon-left flag-icon-{{ $icon }}"></span><a href="#">{{ $value->pais->pais }}</a></td>
                                    <td><img src="https://www.google.com/s2/favicons?domain=http://{{ $value->loja->url }}/" class="favicon-left"><a href="#">{{ $value->loja->descricao }}</a></td>
                                    <td>{{ $value->device }}</td>
                                    <td>{{date('d/m/Y', strtotime($value['created_at']))}}</td>
                                    <td class="center visible-md visible-lg">
                                        <div class="btn-action3">
                                            <span class="btn-sm {{ $turno1 }}"   data-tt="tooltip" title="Manhã"><a href="#" class="show-modal"  data-toggle="modal" data-target="#modal-ver" data-id="{{$value->id}}" data-loja="{{$value->loja_id}}" data-hora="{{$value->loja->hora1}}" data-date="{{$value->created_at}}"><i class="fa fa-cloud"></i></a></span>
                                            <span class="btn-sm {{ $turno2 }}" data-tt="tooltip" title="Tarde"><a href="#" class="show-modal"  data-toggle="modal" data-target="#modal-ver" data-id="{{$value->id}}" data-loja="{{$value->loja_id}}" data-hora="{{$value->loja->hora2}}" data-date="{{$value->created_at}}"><i class="fa fa-sun-o"></i></a></span>
                                            <span class="btn-sm {{ $turno3 }}" data-tt="tooltip" title="Noite"><a href="#"  class="show-modal" data-toggle="modal" data-target="#modal-ver" data-id="{{$value->id}}" data-loja="{{$value->loja_id}}" data-hora="{{$value->loja->hora3}}" data-date="{{$value->created_at}}"><i class="fa fa-moon-o"></i></a></span>
                                        </div>
                                    </td>
                                    <td class="center">
                                        <div class="btn-group btn-action3">
                                            {{--<button type="button" class="btn btn-warning" id="getRequest">getRequest</button>--}}
                                            <a href="#" data-tt="tooltip" title="Histórico"  class="btn btn-default btn-sm"><i class="fa fa-history"></i></a>
                                            <a href="#" data-tt="tooltip" title="Excluir"  class="btn btn-default btn-sm"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

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

                        <div class="modal" id="modal-ver" style="display:none;"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                            <div class="modal-dialog modal-lg">

                              {{--  @include('scraps.modal', ['loja_id' => '8'])--}}
                                <div id="postRequestData">
                                    @if(isset($dados))
                                        <?php echo 'entrei aqui'; ?>
                                    @endif

                                </div>
                            </div>
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

@endsection
