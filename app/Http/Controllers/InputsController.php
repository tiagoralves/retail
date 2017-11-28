<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Http\Requests;
use App\TipoAnuncio;
use App\TipoPagina;
use Illuminate\Http\Request;
use App\Pais;
use App\Loja;
use App\Scrap;
use App\Marca;
use App\Http\Controllers\Auth;
use Carbon\Carbon;

use DB;
use Session;



class InputsController extends Controller
{
 /*   public function index(Request $request)
    {
        $paises = $this->paises();
        $marcas = $this->marcas();
        $tipoPagina = $this->tipoPagina();
        $categorias = $this->getCategorias();
        $tipoAnuncio = $this->getTipoAnuncio();

        $endingDate = new Carbon('yesterday');
        $startingDate = clone $endingDate;
        $startingDate->subDays(3);

        $totalScrapsAnalise =  Scrap::where('status', 0)->orderBy('id', 'desc')->count();
        $totalScraps =  Scrap::count();
        //$totalScrapProntos =  Scrap::where('status', '=', 1)->count();
        $totalScrapProntos =  Scrap::where('status', '=', 1)->count();


        $totalPer = ($totalScraps/100)*$totalScrapProntos;
        $totalFormat = number_format($totalPer, 2, ',', ',');
        $progresso = round($totalFormat, 1);


        if($totalScrapsAnalise > 0) {

            $scrap =  Scrap::where('status', 0)->orderBy('id', 'desc')->first();
            $scrap->arquivo = $this->getImage($scrap);
           // $scraps =  Scrap::where('status', 0)->select('id')->orderBy('id', 'desc')->get();
            $scraps =  Scrap::select(
                                        'id'
                                    )->where([
                                        ['status', '=', 0],
                                        ['created_at', '>=', $startingDate],
                                        ['created_at', '<=', $endingDate]
                                    ])->get();

        }

        //json
        if(isset($request->scrap_id)){

            $id = $request->scrap_id;
            $scrap =  Scrap::where('id', $id)->first();
            $scrap->pais_id =$scrap->pais->pais;
            $scrap->loja_id =$scrap->loja->descricao;
            $scrap->arquivo =  $this->getImage($scrap);
            $scrap->url =  "https://www.google.com/s2/favicons?domain=http://".$scrap->loja->url;

            return json_encode($scrap);
        }

        return view('inputs.index',  compact('paises'),
            [
                'paises' => $paises,
                'scrap' => $scrap,
                'marcas' => $marcas,
                'categorias' => $categorias,
                'tipoPagina' => $tipoPagina,
                'tipoAnuncio' => $tipoAnuncio,
                'scraps' => $scraps,
                'totalScrapsAnalise'=>$totalScrapsAnalise,
                'progresso' => $progresso
            ]);

    }*/

    public function index(Request $request)
    {
        $paises = $this->paises();
        $marcas = $this->marcas();
        $tipoPagina = $this->tipoPagina();
        $categorias = $this->getCategorias();
        $tipoAnuncio = $this->getTipoAnuncio();
        $scrap = 0;
        $progresso =0;
        $totalScrapsAnalise = 0;
        $scraps = 0;
        $nomePais = 'All Countries';
        $nomeloja = 'All Retailers';

        Session::put('sessao', ['pais' =>  '', 'loja' => '', 'data'=> '', 'nomePais' => $nomePais, 'nomeLoja' => $nomePais]);
        $sessionBusca = Session::get('sessao');

        if(isset($request->scrap_id)){

            $id = $request->scrap_id;
            $scrap =  Scrap::where('id', $id)->first();
            $scrap->pais_id =$scrap->pais->pais;
            $scrap->loja_id =$scrap->loja->descricao;
            $scrap->arquivo =  $this->getImage($scrap);
            $scrap->url =  "https://www.google.com/s2/favicons?domain=http://".$scrap->loja->url;

            return json_encode($scrap);
        }

        return view('inputs.index',  compact('paises'),
            [
                'paises' => $paises,
                'scrap' => $scrap,
                'marcas' => $marcas,
                'categorias' => $categorias,
                'tipoPagina' => $tipoPagina,
                'tipoAnuncio' => $tipoAnuncio,
                'scraps' => $scraps,
                'totalScrapsAnalise'=>$totalScrapsAnalise,
                'progresso' => $progresso,
                'sessionBusca' => $sessionBusca
            ]);

    }


    public function getCategorias()
    {
        $categorias = Categoria::where('id', '<>', 7)->Where('id', '<>', 8)->get();
        return $categorias;
    }

    public function getTipoAnuncio()
    {
        $tipoAnuncios = TipoAnuncio::orderBy('descricao', 'ASC')->get();
        return $tipoAnuncios;
    }

    public function marcas(){
        $marcas = Marca::orderBy('descricao', 'ASC')->get();
        return $marcas;
    }

    public function lojasList(Request $request)
    {
        $lojas = Loja::where('pais_id', $request->country_id)->pluck('descricao', 'id');
        return response()->json($lojas);
    }

    public function paises()
    {
        $paises = Pais::get()->pluck('pais', 'id');
        return $paises;
    }

    public function tipoPagina()
    {
        $tiposPaginas = TipoPagina::where('tipo_pagina', 'category')
            ->orWhere('tipo_pagina', 'homepage')
            ->orWhere('tipo_pagina', 'search')
            ->orderBy('tipo_pagina')
            ->get();
        return $tiposPaginas;
    }

    public function explode($data)
    {
        $data = explode('-', $data);
        return $data;
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $scrap = Scrap::find($id);

        $nomePais = Pais::where('id', $request['pais_id'])->first();
        $nomePais = $nomePais->pais;
        $nomeLoja = Loja::where('id', $request['loja_id'])->first();
        $nomeLoja = $nomeLoja->descricao;


        Session::put('sessao', ['pais' =>  $request['pais_id'], 'loja' => $request['loja_id'], 'data'=> $request['data'], 'nomePais' => $nomePais, 'nomeLoja' => $nomeLoja]);
        $sessionBusca = Session::get('sessao');

        if (!empty($request->submit)) {

            $scrap->id = $id;
            $scrap->tipo_pagina_id = $request->tipo_pagina;
            $scrap->tipo_anuncio_id = $request->tipo_anuncio;
            $scrap->categoria_id = $request->categoria_id;
            $scrap->marca_id = $request->marca_id;
            $scrap->device = $request->device;
            $scrap->place = $request->place;
            $scrap->target = $request->target;
            $scrap->type = $request->type;
            $scrap->titulo = $request->titulo;
            $scrap->produto = $request->produto;
            $scrap->detalhe = $request->detalhe;
            $scrap->call_action = $request->call_action;
            $scrap->preco = $request->preco;
            $scrap->price_from = $request->price_from;
            $scrap->price_install = $request->price_install;
            $scrap->detalhe = $request->detalhe;
            $scrap->status = 1;
            $scrap->user_id = $request->usuario_id;
            $scrap->ad_type = $request->ad_type;
            $scrap->detalhe_tipo_anuncio = $request->ad_type_detail;

            $scrap->save();



            $paises = $this->paises();
            $marcas = $this->marcas();
            $tipoPagina = $this->tipoPagina();
            $categorias = $this->getCategorias();
            $tipoAnuncio = $this->getTipoAnuncio();

            $totalScrapsAnalise =  Scrap::where('status', 0)->count();
            $totalScraps =  Scrap::count();
            $totalScrapProntos =  Scrap::where('status', '=', 1)->count();

            $progresso = ($totalScraps/100)*$totalScrapProntos;

            if($totalScrapsAnalise > 0) {
                $id = +1;
                $scrap =  Scrap::where('id', $id)->where('status',0)->first();
                $scraps =  Scrap::where('status', 0)->select('id')->get();

            }


            return redirect()->action(
                'InputsController@index', [
                    'paises' => $paises,
                    'scrap' => $scrap,
                    'marcas' => $marcas,
                    'categorias' => $categorias,
                    'tipoPagina' => $tipoPagina,
                    'tipoAnuncio' => $tipoAnuncio,
                    'scraps' => $scraps,
                    'totalScrapsAnalise'=>$totalScrapsAnalise,
                    'progresso' => $progresso,
                    'sessionBusca' => $sessionBusca,
                ]
            )->with('status', 'Input salvo com sucesso!');


        } else {

            $scrap->id = $id;
            $scrap->status = 5;
            $scrap->user_id = $request->usuario_id;
            $scrap->save();

            $paises = $this->paises();
            $marcas = $this->marcas();
            $tipoPagina = $this->tipoPagina();
            $categorias = $this->getCategorias();
            $tipoAnuncio = $this->getTipoAnuncio();

            $totalScrapsAnalise =  Scrap::where('status', 0)->count();
            $totalScraps =  Scrap::count();
            $totalScrapProntos =  Scrap::where('status', '<>', 0)->count();

            $progresso = ($totalScraps/100)*$totalScrapProntos;

            if($totalScrapsAnalise > 0) {
                $id = +1;
                $scrap =  Scrap::where('id', $id)->where('status',0)->first();
                $scraps =  Scrap::where('status', 0)->select('id')->get();

            }


            return redirect()->action(
                'InputsController@index', [
                    'paises' => $paises,
                    'scrap' => $scrap,
                    'marcas' => $marcas,
                    'categorias' => $categorias,
                    'tipoPagina' => $tipoPagina,
                    'tipoAnuncio' => $tipoAnuncio,
                    'scraps' => $scraps,
                    'totalScrapsAnalise'=>$totalScrapsAnalise,
                    'progresso' => $progresso,
                    'sessionBusca' => $sessionBusca,
                ]
            )->with('message', 'Input descartado!');

        }


    }

    public function search(Request $request)
    {
        $paises = $this->paises();
        $marcas = $this->marcas();
        $tipoPagina = $this->tipoPagina();
        $categorias = $this->getCategorias();
        $tipoAnuncio = $this->getTipoAnuncio();
        $scrap = 0;
        $progresso =0;
        $totalScrapsAnalise = 0;
        $scraps = 0;


        $nomePais = Pais::where('id', $request['pais_id'])->first();
        $nomePais = $nomePais->pais;
        $nomeLoja = Loja::where('id', $request['loja_id'])->first();
        $nomeLoja = $nomeLoja->descricao;


        Session::put('sessao', ['pais' =>  $request['pais_id'], 'loja' => $request['loja_id'], 'data'=> $request['data'], 'nomePais' => $nomePais, 'nomeLoja' => $nomeLoja]);
        $sessionBusca = Session::get('sessao');

        if(!empty($request['data'])) {

            $pais_id = $request['pais_id'];
            $loja_id = $request['loja_id'];

            $data = $this->explode($request['data']);
            $datai = date('Y-m-d', strtotime($data[0]));
            $dataf = date('Y-m-d', strtotime($data[1]));


            $totalScrapsAnalise =  Scrap::where('pais_id', $pais_id)
                ->where('loja_id',  $loja_id)
                ->where('status', 0)
                ->where(DB::raw("DATE(created_at)"),'>=',$datai)
                ->where(DB::raw("DATE(created_at)"),'<=',$dataf)
                ->count();

            $totalScraps =  Scrap::where('pais_id', $pais_id)
                ->where('loja_id',  $loja_id)
                ->where(DB::raw("DATE(created_at)"),'>=',$datai)
                ->where(DB::raw("DATE(created_at)"),'<=',$dataf)
                ->count();


            $totalScrapProntos =  Scrap::where('status', 1)->count();

            //$totalScraps = round($totalScraps,2);
            //$totalScrapProntos = round($totalScrapProntos,2);

            //$totalScraps = round($totalScraps,0);
            //$totalScrapProntos = round($totalScrapProntos,0);

            $totalPer = ($totalScraps*$totalScrapProntos)/1000;
            //$progresso = ($totalScraps*$totalScrapProntos)/1000;
            $progresso = round($totalPer, 2);
//            $formata = number_format($totalPer, 2, ',', '');
//            $progresso = round($formata, 2);

            //$progresso = number_format($totalPer,0,',','.');
            //$progresso = $totalPer;


            if($totalScrapsAnalise > 0) {

                $scrap =  Scrap::where('pais_id', $pais_id)
                    ->where('loja_id',  $loja_id)
                    ->where('status',  0)
                    ->where(DB::raw("DATE(created_at)"),'>=',$datai)
                    ->where(DB::raw("DATE(created_at)"),'<=',$dataf)
                    ->first();

                $scrap->arquivo =  $this->getImage($scrap);


                $scraps =  Scrap::where('pais_id', $pais_id)
                                ->where('loja_id',  $loja_id)
                                ->where('status', 0)
                                ->where(DB::raw("DATE(created_at)"),'>=',$datai)
                                ->where(DB::raw("DATE(created_at)"),'<=',$dataf)
                                ->select('id')->get();

                return view('inputs.index',  compact('paises'),
                    [
                        'paises' => $paises,
                        'scrap' => $scrap,
                        'marcas' => $marcas,
                        'categorias' => $categorias,
                        'tipoPagina' => $tipoPagina,
                        'tipoAnuncio' => $tipoAnuncio,
                        'scraps' => $scraps,
                        'totalScrapsAnalise'=>$totalScrapsAnalise,
                        'progresso' => $progresso,
                        'sessionBusca' => $sessionBusca,
                        'totalScrapsAnalise' => $totalScrapsAnalise
                    ]);

            } else {

                $request->session()->flash('status', 'Sem dados para o período selecionado.');

                return view('inputs.index',  compact('paises'),
                    [
                        'paises' => $paises,
                        'scrap' => $scrap,
                        'marcas' => $marcas,
                        'categorias' => $categorias,
                        'tipoPagina' => $tipoPagina,
                        'tipoAnuncio' => $tipoAnuncio,
                        'scraps' => $scraps,
                        'totalScrapsAnalise'=>$totalScrapsAnalise,
                        'progresso' => $progresso,
                        'sessionBusca' => $sessionBusca,
                        'totalScrapsAnalise' => $totalScrapsAnalise,
                    ]);
            }

        }


        return view('inputs.index',  compact('paises'),
            [
                'paises' => $paises,
                'scrap' => $scrap,
                'marcas' => $marcas,
                'categorias' => $categorias,
                'tipoPagina' => $tipoPagina,
                'tipoAnuncio' => $tipoAnuncio,
                'scraps' => $scraps,
                'totalScrapsAnalise'=>$totalScrapsAnalise,
                'progresso' => $progresso,
                'sessionBusca' => $sessionBusca,
                'totalScrapsAnalise' => $totalScrapsAnalise
            ]);




    }

 /*   public function search(Request $request)
    {

        $paisID = $request['pais_id'];
        $lojaID = $request['loja_id'];
        $dataID = $request['data'];

        //print_r(session()->get($paisID)); exit();




        $paises = $this->paises();
        $marcas = $this->marcas();
        $tipoPagina = $this->tipoPagina();
        $categorias = $this->getCategorias();
        $tipoAnuncio = $this->getTipoAnuncio();

        $scrap = '';
        $totalScraps = 0;
        $scraps = 0;

        if(!empty($request['data'])) {

            $pais_id = $request['pais_id'];
            $loja_id = $request['loja_id'];

            $data = $this->explode($request['data']);
            $datai = date('Y-m-d', strtotime($data[0]));
            $dataf = date('Y-m-d', strtotime($data[1]));


            $totalScrapsAnalise =  Scrap::where('pais_id', $pais_id)
                ->where('loja_id',  $loja_id)
                ->where(DB::raw("DATE(created_at)"),'>=',$datai)
                ->where(DB::raw("DATE(created_at)"),'<=',$dataf)
                ->count();


            $totalScrapProntos =  Scrap::where('status', '=', 1)->count();
            $totalPer = ($totalScraps/100)*$totalScrapProntos;
            $totalFormat = number_format($totalPer, 2, ',', ',');
            $progresso = round($totalFormat, 1);


            if($totalScrapsAnalise > 0) {

                $scrap =  Scrap::where('pais_id', $pais_id)
                    ->where('loja_id',  $loja_id)
                    ->where(DB::raw("DATE(created_at)"),'>=',$datai)
                    ->where(DB::raw("DATE(created_at)"),'<=',$dataf)
                    ->first();

                $scrap->arquivo =  $this->getImage($scrap);


                $scraps =  Scrap::where('status', '=', 0)
                    ->orwhereNull('status')
                    ->where(DB::raw("DATE(created_at)"),'>=',$datai)
                    ->where(DB::raw("DATE(created_at)"),'<=',$dataf)->select('id')->get();


                return view('inputs.index',  compact('paises'),
                    [
                        'paises' => $paises,
                        'scrap' => $scrap,
                        'marcas' => $marcas,
                        'categorias' => $categorias,
                        'tipoPagina' => $tipoPagina,
                        'tipoAnuncio' => $tipoAnuncio,
                        'scraps' => $scraps,
                        'totalScrapsAnalise'=>$totalScrapsAnalise,
                        'progresso' => $progresso,
                        'paisID' => $paisID,
                        'lojaID' => $lojaID
                    ]);

                return redirect()->action(
                    'InputsController@index', [
                        'paises' => $paises,
                        'scrap' => $scrap,
                        'marcas' => $marcas,
                        'categorias' => $categorias,
                        'tipoPagina' => $tipoPagina,
                        'tipoAnuncio' => $tipoAnuncio,
                        'scraps' => $scraps,
                        'totalScrapsAnalise'=>$totalScrapsAnalise,
                        'progresso' => $progresso
                    ]
                )
                    ->with('paisID', $paisID)
                    ->with('lojaID', $lojaID)
                    ->with('dataID', $dataID)
                    ->with('status', 'Dados Encontrados');


            } elseif($totalScrapsAnalise == 0) {

                $scrap =  Scrap::where('status', '=', 0)->orderBy('id', 'desc')->first();

                $paisBusca = strtolower($scrap->pais->pais);
                $paisBusca = $this->tirarAcentos($paisBusca);


                $dt = explode(" ", $scrap->created_at);
                $datapasta = explode("-", $dt[0]);
                $anopasta = $datapasta[0];
                $mespasta = $datapasta[1];


                if($scrap->device == 'Desktop') {
                    $diretorioImportio = '/printshtml/'.$paisBusca.'/desktop/'.$anopasta.'/'.$mespasta.'/';
                } elseif ($scrap->device == 'Mobile') {
                    $diretorioImportio = '/printshtml/'.$paisBusca.'/mobile/'.$anopasta.'/'.$mespasta.'/';

                }

                $scrap->arquivo = $diretorioImportio.$scrap->arquivo;

                $scraps =  Scrap::where('status', '=', 0)->orwhereNull('status')->select('id')->get();

                return redirect()->action(
                    'InputsController@index', [
                        'paises' => $paises,
                        'scrap' => $scrap,
                        'marcas' => $marcas,
                        'categorias' => $categorias,
                        'tipoPagina' => $tipoPagina,
                        'tipoAnuncio' => $tipoAnuncio,
                        'scraps' => $scraps,
                        'totalScrapsAnalise'=>$totalScrapsAnalise,
                        'progresso' => $progresso
                    ]
                )
                    ->with('paisID', $paisID)
                    ->with('lojaID', $lojaID)
                    ->with('dataID', $dataID)
                    ->with('message', 'Sem dados pra essa data!');


            }

        }

    }*/


    public function getImage($scrap)
    {
        $paisBusca = strtolower($scrap->pais->pais);
        $paisBusca = $this->tirarAcentos($paisBusca);


        $dt = explode(" ", $scrap->created_at);
        $datapasta = explode("-", $dt[0]);
        $anopasta = $datapasta[0];
        $mespasta = $datapasta[1];


        if($scrap->device == 'Desktop') {
            $diretorioImportio = '/printshtml/'.$paisBusca.'/desktop/'.$anopasta.'/'.$mespasta.'/';
        } elseif ($scrap->device == 'Mobile') {
            $diretorioImportio = '/printshtml/'.$paisBusca.'/mobile/'.$anopasta.'/'.$mespasta.'/';

        }

        return $arquivo = $diretorioImportio.$scrap->arquivo;

    }

    function tirarAcentos($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
    }


    public function destroy($id)
    {

    }
}

