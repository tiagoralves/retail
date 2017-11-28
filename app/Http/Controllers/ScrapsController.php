<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use  Illuminate\Support\Facades\Response;
use App\Scrap;
use App\Loja;
use App\Url;
use App\Screenshot;
use DB;


class ScrapsController extends Controller
{
    public function index()
    {
        $scraps = Scrap::groupBy(DB::raw('Date(created_at)'),'loja_id', 'device')
                 ->orderBy('created_at', 'desc')
                 ->get();

        
        return view('scraps.index',['scraps' => $scraps]);
    }


    public function show($id, $data, $device, $hora)
    {
      if($hora=='h1'){
          $turno = 'G1';
      }elseif($hora=='h2'){
          $turno = 'G2';
      }elseif ($hora=='h3'){
          $turno = 'G3';
      }


     $loja = Loja::find($id);
     $dt = explode(" ", $data);
     $datapasta = explode("-", $dt[0]);
     $anopasta = $datapasta[0];
     $mespasta = $datapasta[1];
     $pais = strtolower($loja->pais->pais);
     $pais = $this->tirarAcentos($pais);

  if($device == 'Desktop') {
         $diretorioImportio = '/printshtml/'.$pais.'/desktop/'.$anopasta.'/'.$mespasta.'/';
          $diretorioUrlbox = '/screenshots/'.$pais.'/desktop/'.$anopasta.'/'.$mespasta.'/';

     }  elseif($device == 'Mobile') {
         $diretorioImportio = '/printshtml/'.$pais.'/mobile/'.$anopasta.'/'.$mespasta.'/';
         $diretorioUrlbox = '/screenshots/'.$pais.'/mobile/'.$anopasta.'/'.$mespasta.'/';
     }


         $home = Scrap::where(DB::raw("DATE(created_at)"), $dt[0])
            ->where('loja_id', $id)
            ->where('tipo_pagina_id', 1)
            ->where('turno', $turno)
            ->where('place', 'Listagem')
            ->where('device', $device)
            ->orderBy('created_at', 'desc')
            ->get();

         $carrossel = Scrap::where(DB::raw("DATE(created_at)"), $dt[0])
                 ->where('loja_id', $id)
                 ->where('tipo_pagina_id', 2)
                 ->where('turno', $turno)
                 ->where('device', $device)
                 ->where('place', 'Carousel')
                 ->get();

             $ads = Scrap::where(DB::raw("DATE(created_at)"), $dt[0])
                 ->where('loja_id', $id)
                 ->where('tipo_pagina_id', 3)
                 ->where('turno', $turno)
                 ->where('device', $device)
                 ->where('place', 'Ad Placement')
                 ->get();

            $url = Url::where('loja_id', $id)->where('device', $device)->where('categoria_id', 1)->first();
             $smartfones = Scrap::where(DB::raw("DATE(created_at)"), $dt[0])
                 ->where('loja_id', $id)
                 ->where('tipo_pagina_id', 4)
                 ->where('url', $url->id)
                 ->where('turno', $turno)
                 ->where('device', $device)
                 ->where('type', 'Organic')
                 ->get();

           $url = Url::where('loja_id', $id)->where('device', $device)->where('categoria_id', 2)->first();
             $tvs = Scrap::where(DB::raw("DATE(created_at)"), $dt[0])
                 ->where('loja_id', $id)
                 ->where('tipo_pagina_id', 4)
                 ->where('url', $url->id)
                 ->where('turno', $turno)
                 ->where('device', $device)
                 ->where('type', 'Organic')
                 ->get();

             $url = Url::where('loja_id', $id)->where('device', $device)->where('categoria_id', 3)->first();
             $geladeiras = Scrap::where(DB::raw("DATE(created_at)"), $dt[0])
                 ->where('loja_id', $id)
                 ->where('tipo_pagina_id', 4)
                 ->where('url', $url->id)
                 ->where('turno', $turno)
                 ->where('device', $device)
                 ->where('type', 'Organic')
                 ->get();

             $url = Url::where('loja_id', $id)->where('device', $device)->where('categoria_id', 4)->first();
             $maquinadelavar = Scrap::where(DB::raw("DATE(created_at)"), $dt[0])
                 ->where('loja_id', $id)
                 ->where('tipo_pagina_id', 4)
                 ->where('url', $url->id)
                 ->where('turno', $turno)
                 ->where('device', $device)
                 ->where('type', 'Organic')
                 ->get();

             $screenshotsHome = Screenshot::where(DB::raw("DATE(created_at)"), $dt[0])
                             ->where('loja_id', $id)
                             ->where('device', $device)
                             ->where('tipo_pagina', 'Homepage_')
                             ->first();

             $screenshotsTv = Screenshot::where(DB::raw("DATE(created_at)"), $dt[0])
                 ->where('loja_id', $id)
                 ->where('device', $device)
                 ->where('tipo_pagina', 'TVs_')
                 ->first();

             $screenshotsSmartphones = Screenshot::where(DB::raw("DATE(created_at)"), $dt[0])
                 ->where('loja_id', $id)
                 ->where('device', $device)
                 ->where('tipo_pagina', 'Smartphones_')
                 ->first();

             $screenshotsRefrigerators = Screenshot::where(DB::raw("DATE(created_at)"), $dt[0])
                 ->where('loja_id', $id)
                 ->where('device', $device)
                 ->where('tipo_pagina', 'Refrigerators_')
                 ->first();

             $screenshotsWashing = Screenshot::where(DB::raw("DATE(created_at)"), $dt[0])
                 ->where('loja_id', $id)
                 ->where('device', $device)
                 ->where('tipo_pagina', 'Washing Machines_')
                 ->first();

        return view('scraps.modal', [
                                        'home' => $home,
                                        'carrossel' => $carrossel,
                                        'ads' => $ads,
                                        'loja' => $loja,
                                        'data' => $dt[0],
                                        'device' => $device,
                                        'smartfones'=> $smartfones,
                                        'tvs' => $tvs,
                                        'geladeiras' => $geladeiras,
                                        'maquinadelavar' => $maquinadelavar,
                                        'screenshotsHome' => $screenshotsHome,
                                        'screenshotsTv' => $screenshotsTv,
                                        'screenshotsSmartphones' => $screenshotsSmartphones,
                                        'screenshotsRefrigerators'=>$screenshotsRefrigerators,
                                        'screenshotsWashing' => $screenshotsWashing,
                                        'diretorioImportio' => $diretorioImportio,
                                        'diretorioUrlbox' =>$diretorioUrlbox

                            ]);
    }

    function tirarAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
    }

    
}
