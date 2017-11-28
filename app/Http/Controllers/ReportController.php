<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Categoria;
use App\Marca;
use App\Pais;
use App\Scrap;
use App\Loja;
use DB;


class ReportController extends Controller
{
    public function loadReportOverview()
    {
        $countries = DB::table('paises')->pluck("pais","id")->all();



       $categorias = Categoria::where('id', '<=', 4)->get();
        $countMarcas = [];
        $paises = Pais::all();
        $marcas = Marca::all();


        //calculo total retail por País
        $countScrapsPais =  Scrap::where('pais_id', 1)->where('marca_id','<>', 0)->count();

        //calculo shere of shelf
        $countShare = Scrap::where('pais_id', 1)->where('marca_id', 1)->count();
        $lojas = Loja::where('pais_id', 1)->get();

        $porcentagemProduto = $this->calPorcentagem($countShare, $countScrapsPais);
        $percentualShereOfShelf =  $this->convertPercentage($porcentagemProduto);


        //calculo Competitors Share of Shelf Categories
        foreach ( $marcas as $marca) {
                $countMarca = Scrap::where('pais_id', 1)->where('marca_id', $marca->id)->count();

                if($countMarca) {
                    $countMarca = $this->calPorcentagem($countMarca, $countScrapsPais);
                    $countMarcas[] = ['y' => $countMarca, 'color' => '#3D96AE', 'name' => $marca->descricao];
                }
        }

        //calculo Search Coverage
        $countSearchCoverage = 0;


        //calculo  Category by Retailers (lojas)
       $countCatByRetailers = DB::table('scraps')
            ->where('scraps.pais_id', '=', 1)
            ->where('scraps.tipo_pagina_id', '=', 4)
            ->join('categorias', 'scraps.categoria_id', '=', 'categorias.id')
            ->join('lojas', 'scraps.loja_id', '=', 'lojas.id')
            ->select('categorias.descricao', 'lojas.descricao as loja', DB::raw("count(scraps.id) as count"))
            ->groupBy('scraps.categoria_id', 'scraps.loja_id')
            ->get();

        $countScrapsCategory =  Scrap::where('pais_id', 1)->where('tipo_pagina_id', 4)->count();

        foreach ($countCatByRetailers as $value){
           $categoryByRetailrs[] = ['name' =>$value->descricao, 'loja' => $value->loja,'color' =>'#272727', ''=> $value->count];
        }


        foreach ( $categorias as $value) {
            $countCategoria = Scrap::where('pais_id', 1)->where('categoria_id', $value->id)->count();
            if($countCategoria) {

                $countCatByCategoria = $this->calPorcentagem($countCategoria, $countScrapsCategory);
                $countCatByCategoria = $this->convertPercentage($countCatByCategoria);
                $countCatByRetail[] = ['name' => $value->descricao, 'color' => '#30B8F1', 'countCatByCategoria' => $countCatByCategoria];
            }
        }



        //Popular Products
        $produtos = Scrap::selectRaw('*, count(*) as total')->where('produto', '<>', '')->where('pais_id', 1)->groupBy('produto')->orderBy('total', 'desc')->limit(10)->get();

        //Display Share
        foreach ( $marcas as $marca) {
            $countDisplayShare = Scrap::where('pais_id', 1)->where('marca_id', $marca->id)->where('tipo_pagina_id', 3)->count();

            if($countDisplayShare) {
                $displayShare[] = ['y' => $countDisplayShare, 'color' => '#3D96AE', 'name' => $marca->descricao];
            }
        }


        //Ads by Category
        $adsByCategory = Scrap::where('pais_id', 1)->where('tipo_pagina_id', 3)->count();


        //Ads by Retailer
        $countAdsByRetailers = DB::table('scraps')
            ->where('scraps.pais_id', '=', 1)
            ->where('scraps.tipo_pagina_id', '=', 3)
            ->join('categorias', 'scraps.categoria_id', '=', 'categorias.id')
            ->select('categorias.descricao', DB::raw("count(scraps.id) as count"))
            ->groupBy('scraps.categoria_id')
            ->get();


        foreach ($countAdsByRetailers as $value) {
            $adsbycategoryCount[]= ['name' => $value->descricao,'color' => '#7030a0','data' => [$value->count]];
        }

        $countCategoria = Scrap::where('pais_id', 1)->where('tipo_pagina_id', 3)->count();

        foreach ($categorias as $value){

            $countAdsRetailer = Scrap::where('pais_id', 1)->where('tipo_pagina_id', 3)->where('categoria_id', $value->id)->count();
            $countAdsRetailer = $this->convertPercentage($countAdsRetailer, $countCategoria);
            $countAdsRetailer = $this->convertPercentage($countAdsRetailer);

            $adsByRetailer[] = ['categoria' => $value->descricao, 'countAdsRetailer' => $countAdsRetailer];
        }


        //Ads by Brand
        foreach ( $marcas as $marca) {
            $countAdsBrand = Scrap::where('pais_id', 1)->where('marca_id', $marca->id)->where('tipo_pagina_id', 3)->count();

            if($countAdsBrand) {
                //   $countMarca = $this->calPorcentagem($countMarca, $countScrapsPais);
                $adsBrand[] = ['y' => $countAdsBrand];


            }
        }

        //json lojas e urls
        foreach ($lojas as $value) {
            $lojasJson[] = $value->descricao;
            $lojasUrlJson[] = $value->url;
        }

        $percentualMarcas = $countMarcas;
        return view('reports.report_overview',  compact('countries'), [
                                                    'percentualShereOfShelf' => $percentualShereOfShelf,
                                                    'categorias' => $categorias,
                                                    'marcas' => $marcas,
                                                    'paises' => $paises,
                                                    'percentualMarcas' => $percentualMarcas,
                                                    'lojas' =>$lojas,
                                                    'countSearchCoverage' => $countSearchCoverage,
                                                    'countCatByRetail' => $countCatByRetail,
                                                    'produtos' => $produtos,
                                                    'lojasJson' => $lojasJson,
                                                    'lojasUrlJson' => $lojasUrlJson,
                                                    'adsByRetailer' => $adsByRetailer,
                                                    'adsbycategoryCount' => $adsbycategoryCount,
                                                    'displayShare' => $displayShare,
                                                    'adsBrand' => $adsBrand
                                        ]);

    }

    public function loadShereOfShelf()
    {
        return view('reports.report_shelf');

    }

    public function loadSearch()
    {
        return view('reports.report_search');
    }

    public function data()
    {
        return view('reports.data');
    }

    public function form()
    {
        $countries = Pais::get()->pluck('pais', 'id');
        return view('reports.form', compact('countries'));
    }


    public function lojasList(Request $request)
    {
        $lojas = Loja::where('pais_id', $request->country_id)->pluck('descricao', 'id');
        return response()->json($lojas);
    }

    public function convertPercentage($valor)
    {
        $valor = @number_format($valor, 1, '.', ',');
        return $valor;
    }

    public function  calPorcentagem($valo1, $valo2)
    {
        $porcento = ($valo1/$valo2)*100;
        return $porcento;
    }

    public function selectAjax(Request $request)
    {
        if($request->ajax()){
            $retails = Scrap::where('pais_id',$request->id)->pluck("descicao","id")->all();
            $data = view('ajax-select',compact('$retails'))->render();
            return response()->json(['options'=>$data]);
        }
    }
}
