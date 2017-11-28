<?php

namespace App\Http\Controllers;

use App\Loja;
use App\Scrap;
use App\Screenshot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function getCategoryByRetailersJson(){

        $endingDate = new Carbon('yesterday');
        $startingDate = clone $endingDate;
        $startingDate->subDays(30);

        $idsToBeSelected = [];
        $aggregateMaxByLojas = DB::table('screenshots')
            ->select(
                'loja_id',
                DB::raw('count(id) as qtd')
            )
            ->where([
                ['tipo_pagina', '<>', ''],
                ['created_at', '>=', $startingDate],
                ['created_at', '<=', $endingDate]
            ])
            ->groupBy('loja_id')
            ->take(10)
            ->get();

        foreach($aggregateMaxByLojas as $aggregateResult){
//            var_dump($aggregateResult);
            array_push($idsToBeSelected, $aggregateResult->loja_id);
        }



        $finalAggregateResult = DB::table('screenshots')
            ->select(
                'tipo_pagina',
                'loja_id',
                DB::raw('count(id) as qtd')
            )
            ->where([
                ['tipo_pagina', '<>', ''],
                ['created_at', '>=', $startingDate],
//                ['loja_id', 'in', $idsToBeSelected],
                ['created_at', '<=', $endingDate]
            ])
            ->whereIn('tipo_pagina', ['Homepage_', 'Refrigerators_', 'Smartphones_', 'TVs_'])
            ->whereIn('loja_id', $idsToBeSelected)
            ->groupBy('loja_id', 'tipo_pagina')
            ->get();

        dd($finalAggregateResult);
//
//
//        SELECT
//tipo_pagina,
//loja_id,
//count(id)
//    FROM
//        retail.screenshots
//    where
//        tipo_pagina <> '' AND
//        loja_id in (3, 5,9,10,12,14,16,17,19,24) AND
//        tipo_pagina in ('Homepage_', 'Refrigerators_', 'Smartphones_', 'TVs_')
//    GROUP BY
//tipo_pagina,
//loja_id;


//

        echo '
        {
            "0": [
                {
                    "name": "Smartphone",
                    "color": "#272727",
                    "data": [221,113,331,201,127,161,117,181,219,100],
                    "variance" : 17.5
                }, {
                    "name": "TV",
                    "color": "#5b9bd5",
                    "data": [172,222,313,114,125,263,117,182,149,280],
                    "variance" : -18.9
                }, {
                    "name": "Washing Machine",
                    "color": "#70ad47",
                    "data": [112,192,123,214,115,265,117,135,119,190],
                    "variance" : 12.5
                },{
                    "name": "Refrigerator",
                    "color": "#7030a0",
                    "visible": "true",
                    "data": [121,192,113,204,155,116,171,174,129,150],
                    "variance" : -35.9
                }
            ],
            "1": ["americanas.com.br","carrefour.com.br","casasbahia.com.br",
                  "extra.com.br", "fastshop.com.br", "magazineluiza.com.br",
                  "pontofrio.com.br","ricardoeletro.com.br","submarino.com","walmart.com.br"]
        }
        ';
    }
    public function getAdsByBrandJson(){
        echo '
        {
            "categories" : ["samsung.com.br","apple.com.br","lge.com.br","sony.com.br","motorola.com.br","huawei.com","lenovo.com.br","meuquantum.com.br","loja.asus.com.br"],
            "series":
                [{
                    "data": [121,103,101,64,127,61,17,81,43]
                }]
        }
        ';
    }

    public function getAdsByCategoryJson(){
        echo '
        {
            "categories" : ["Week 28","Week 29","Week 30","Week 31","Week 32","Week 33","Week 34","Week 35","Week 36","Week 37"],
            "series": [{
                "name": "Refrigerator",
                    "color": "#7030a0",
                    "visible": "true",
                    "data": [81,92,13,54,55,16,71,74,29,50]
                }, {
                "name": "Washing Machine",
                    "color": "#70ad47",
                    "data": [112,92,23,14,15,65,17,35,19,90]
                }, {
                "name": "TV",
                    "color": "#5b9bd5",
                    "data": [72,22,33,14,25,63,17,82,49,80]
                },{
                "name": "Smartphone",
                    "color": "#272727",
                    "data": [21,103,31,104,97,61,17,81,19,100]
                }]
        }
        ';
    }
    public function getAdsByRetailerJson(){
        echo '';
    }
    public function getCompetitorsShareOfShelfJson(){
        echo '
            [
                {
                    "y": 18,
                    "color": "#0070c0",
                    "name": "Samsung"
                },{
                    "y": 13,
                    "color": "#777574",
                    "name": "Apple"
                },{
                    "y": 10,
                    "color": "#e26405",
                    "name": "Motorola"
                },{
                    "y": 8,
                    "color": "#792e9d",
                    "name": "Brastemp"
                },{
                    "y": 8,
                    "color": "#00b05c",
                    "name": "Sony"
                },{
                    "y": 4,
                    "color": "#ff0000",
                    "name": "LG"
                },{
                    "y": 1,
                    "color": "#eabb19",
                    "name": "Electrolux"
                }
            ]
        ';
    }
    public function getDisplayShareJson(){
        echo '
        {
            "0":
                {
                    "historic": {"value": 15.6, "since": "19/05/2017"},
                    "evolution": {"value": 25.9, "since": "19/08/2017"},
                    "display_share": 15.8,
                    "series":  [42.2, 26.2, 37.9, 44.5, 39.1, 32.1]
                },
            "1": [
                    {
                        "y": 28,
                        "color": "#0070c0",
                        "name": "Samsung"
                    },{
                        "y": 25,
                        "color": "#e26405",
                        "name": "Motorola"
                    },{
                        "y": 22,
                        "color": "#792e9d",
                        "name": "Brastemp"

                    },{
                        "y": 13,
                        "color": "#777574",
                        "name": "Apple"
                    },{
                        "y": 8,
                        "color": "#00b05c",
                        "name": "Sony"
                    },{
                        "y": 3,
                        "color": "#ff0000",
                        "name": "LG"
                    },{
                        "y": 2,
                        "color": "#eabb19",
                        "name": "Electrolux"
                    }
                ]
            }';
    }
    public function getPopularProductsJson(){
        echo '
        {
            "0": [
                {
                    "name": "Smartphone",
                    "color": "#272727",
                    "data": [221,113,331,201,127,161,117,181,219,100],
                    "variance" : 17.5
                }, {
                    "name": "TV",
                    "color": "#5b9bd5",
                    "data": [172,222,313,114,125,263,117,182,149,280],
                    "variance" : -18.9
                }, {
                    "name": "Washing Machine",
                    "color": "#70ad47",
                    "data": [112,192,123,214,115,265,117,135,119,190],
                    "variance" : 12.5
                },{
                    "name": "Refrigerator",
                    "color": "#7030a0",
                    "visible": "true",
                    "data": [121,192,113,204,155,116,171,174,129,150],
                    "variance" : -35.9
                }
            ],
            "1": ["americanas.com.br","carrefour.com.br","casasbahia.com.br",
                  "extra.com.br", "fastshop.com.br", "magazineluiza.com.br",
                  "pontofrio.com.br","ricardoeletro.com.br","submarino.com","walmart.com.br"]
        }
        ';
    }
    public function getSearchCoverageJson(){
        echo '{
            "historic": {"value": 15.6, "since": "19/05/2017"},
            "evolution": {"value": 25.9, "since": "19/08/2017"},
            "share_of_shelf": 15.8,
            "series": [12, 20, 35, 45, 55, 65]
            }';
    }
    public function getShareOfShelfJson(){
        $this->getShareOfShelfSeries();
        echo '{
            "historic": {"value": 15.6, "since": "19/05/2017"},
            "evolution": {"value": 25.9, "since": "19/08/2017"},
            "share_of_shelf": ' . $this->getShareOfShelf() . ',
            "series": [' . implode(", ", $this->getShareOfShelfSeries()) . ']
            }';

        //series intervalo de mes em mes
        //share of shelf = quantidade de marcas / total de registros * 100
        //evolution = comparar semana atual - 1 com a semana anterior (semana passada com a retrasada)
        //historic =
    }

    private function getShareOfShelf(){
        $lastSaturday = new Carbon('last saturday');
        $startingDate = clone $lastSaturday;
        $startingDate->subMonths(3);

        $qtdSamsung = DB::table('scraps')
            ->where([
                ['scraps.marca_id', '1'],
                ['scraps.created_at', '<=', $lastSaturday],
                ['scraps.created_at', '>=', $startingDate]
            ])
            ->count('scraps.id');

        $qtdTotal = DB::table('scraps')
            ->where([
                ['scraps.created_at', '<=', $lastSaturday],
                ['scraps.created_at', '>=', $startingDate]
            ])
            ->count('scraps.id');

        $shareOfShelf = number_format( $qtdSamsung / $qtdTotal * 100, 2) ;

        return $shareOfShelf;
    }

    private function getShareOfShelfSeries(){
        $arrayToBeReturned = [];
        $resultTotal = DB::table('scraps')
            ->select(
                DB::raw('YEAR(scraps.created_at) as year'),
                DB::raw('MONTH(scraps.created_at)as month'),
                DB::raw('DAY(scraps.created_at) as day'),
                DB::raw('COUNT(scraps.id) as quantidade'))
//            ->where([
//                ['tipo_pagina', '<>', 'null'],
//                ['scraps.marca_id', '1']])
            ->groupBy([
                DB::raw('YEAR(scraps.created_at)'),
                DB::raw('MONTH(scraps.created_at)'),
                DB::raw('DAY(scraps.created_at)')])
            ->orderBy('scraps.created_at')
            ->get();

        $resultSamsung = DB::table('scraps')
            ->select(
                DB::raw('YEAR(scraps.created_at) as year'),
                DB::raw('MONTH(scraps.created_at)as month'),
                DB::raw('DAY(scraps.created_at) as day'),
                DB::raw('COUNT(scraps.id) as quantidade'))
            ->where([
//                ['tipo_pagina', '<>', 'null'],
                ['scraps.marca_id', '1']])
            ->groupBy([
                DB::raw('YEAR(scraps.created_at)'),
                DB::raw('MONTH(scraps.created_at)'),
                DB::raw('DAY(scraps.created_at)')])
            ->orderBy('scraps.created_at')
            ->get();

        $seriesLenght = count($resultTotal);
        for($i = 0; $i < $seriesLenght; $i ++){
            array_push($arrayToBeReturned, number_format( $resultSamsung[$i]->quantidade / $resultTotal[$i]->quantidade * 100, 2));
        }
        return $arrayToBeReturned;
    }

}
