<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Urlbox\Screenshots\Facades\Urlbox;
use DB;
use App\Marca;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;


class CreateActiveCasasBahia extends Command
{
    protected $signature = 'CreateActiveCasasBahia:insert';
    protected $description = 'Create Screenshots DB';
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        $marcas = Marca::all();
        $marca_id = 0;

        $urlbox = Urlbox::fromCredentials('API_KEY', 'API_SECRET');

        $client = new Client();

        $data = date('Y_m_d H:i:s');
        $dt = explode('_', $data);

        $mes = (int) $dt[1];
        $dh = explode(" ", $dt[2]);
        $dia = (int) $dh[0];
        $data = $dt[0]."_". $mes ."_". $dia;

        $horaG1 = strtotime('03:00');
        $horaG2 = strtotime('11:00');
        $horaG3 = strtotime('19:00');
        $horaAtual = strtotime(date('H:i'));

        if ($horaAtual >= $horaG1 && $horaAtual < $horaG2) {
            $turno = "G1";
        } elseif ($horaAtual >= $horaG2 && $horaAtual < $horaG3){
            $turno = "G2";
        } elseif ($horaAtual >= $horaG3) {
            $turno = "G3";
        }
        //criacao de diretorio desktop
        if(!is_dir("/var/www/html/retail/public/screenshots/brasil/desktop/".$dt[0])) {
            mkdir("/var/www/html/retail/public/screenshots/brasil/desktop/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/screenshots/brasil/desktop/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/screenshots/brasil/desktop/".$dt[0]."/".$dt[1], 0777);
        }
        //criacao de desktop mobile
        if(!is_dir("/var/www/html/retail/public/screenshots/brasil/mobile/".$dt[0])) {
            mkdir("/var/www/html/retail/public/screenshots/brasil/mobile/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/screenshots/brasil/mobile/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/screenshots/brasil/mobile/".$dt[0]."/".$dt[1], 0777);
        }

        $lojadb = DB::table('lojas')->where('descricao', 'Casas Bahia')->first();
        $loja_id = $lojadb->id;
        $pais_id = $lojadb->pais_id;
        $lojaNome = "Casasbahia";


        //CASAS BAHIA
 /*       $urlsDesktop = [
            // casabahia
            'casasbahia.com.br',
            'casasbahia.com.br/TelefoneseCelulares/Smartphones/?Filtro=C38_C326',
            'casasbahia.com.br/tvseacessorios/Televisores/?Filtro=C1_C2',
            'casasbahia.com.br/Eletrodomesticos/GeladeiraeRefrigerador/?Filtro=C13_C14',
            'casasbahia.com.br/Eletrodomesticos/maquinadelavar/?Filtro=C13_C24',
        ];

        $cont = 0;

        foreach ( $urlsDesktop as $value):

            if( $cont==0 ) {
                $tipo = 'Homepage_';
            } elseif( $cont == 1 ) {
                $tipo = 'Smartphones_';
            }elseif( $cont == 2 ) {
                $tipo = 'TVs_';
            }elseif( $cont == 3 ) {
                $tipo = 'Refrigerators_';
            }elseif ( $cont == 4) {
                $tipo = 'Washing Machines_';
            }

            $options["url"] = $value;
            $options["format"] = "jpg";
            $options["quality"] = 70;
            $options["full_page"] = true;
            $options["force"] = true;
            $urlboxUrl = Urlbox::generateUrl($options);

            $url = $urlboxUrl;
            $image = @file_get_contents($url);
            if ($image !== false) {

                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Brasil_".$lojaNome."_Desktop_".$tipo.$data.$turno.".jpg";
                $im = @imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                @imagejpeg($im, "/var/www/html/retail/public/screenshots/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);


                DB::table('screenshots')->insert(
                    [
                        'pais_id' => $pais_id,
                        'loja_id' => $loja_id,
                        'device' => 'Desktop',
                        'tipo_pagina' => $tipo,
                        'link' => $urlboxUrl,
                        'arquivo'=> $name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );

            } else {
                echo 'Ocorreu um erro desktop casas bahias.';
            }
            $cont ++;
        endforeach;


        $urlMobile = [
            'm.casasbahia.com.br/#/',
            'm.casasbahia.com.br/#/departamentos/38_326',
            'm.casasbahia.com.br/#/departamentos/1_2',
            'm.casasbahia.com.br/#/departamentos/13_14',
            'm.casasbahia.com.br/#/departamentos/13_24',
        ];

        $contMobile = 0;

        foreach ( $urlMobile as $value):

            if( $contMobile==0 ) {
                $tipo = 'Homepage_';
            } elseif( $contMobile == 1 ) {
                $tipo = 'Smartphones_';
            }elseif( $contMobile == 2 ) {
                $tipo = 'TVs_';
            }elseif( $contMobile == 3 ) {
                $tipo = 'Refrigerators_';
            }elseif ( $contMobile == 4) {
                $tipo = 'Washing Machines_';
            }

            $options["url"] = $value;
            $options["format"] = "jpg";
            $options["quality"] = 70;
            $options["full_page"] = true;
            $options["user_agent"] = 'mobile';
            $options["force"] = true;
            $urlboxUrl = Urlbox::generateUrl($options);

            $url = $urlboxUrl;
            $image = file_get_contents($url);
            if ($image !== false) {

                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Brasil_".$lojaNome."_Mobile_".$tipo.$data.$turno.".jpg";
                $im = imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                imagejpeg($im, "/var/www/html/retail/public/screenshots/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                DB::table('screenshots')->insert(
                    [
                        'pais_id' => $pais_id,
                        'loja_id' => $loja_id,
                        'device' => 'Mobile',
                        'tipo_pagina' => $tipo,
                        'link' => $urlboxUrl,
                        'arquivo'=> $name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );

            } else {
                echo 'Ocorreu um erro mobil casas bahia.';

            }
            $contMobile ++;
        endforeach;
 */

        //import.io
        //criação diretório desktop
        if(!is_dir("/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0])) {
            mkdir("/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1], 0777);
        }
        //criacao diretório mobile
        if(!is_dir("/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0])) {
            mkdir("/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1], 0777);
        }

        //Brasil_Casasbahia_Desktop_Homepage_Ads
        $requestAds = $client->request('GET', 'https://data.import.io/extractor/bee881a6-c538-40e9-a2d0-a6f25a76cec8/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestAds =  json_decode($requestAds->getBody(), true);

        $dados = $requestAds['result']['extractorData']["data"];
        $position = 1;

        $urlTipo = $requestAds['url'];
        $timestamp = $requestAds["result"]["timestamp"];

        foreach ( $dados as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Desktop_Homepage_ads_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                }

                if (isset($value["Target URL"][0]["text"])){
                    $target = $value["Target URL"][0]["text"];
                } else {
                    $target = "";
                }

                if (isset($value["Place"][0]["text"])){
                    $place = $value["Place"][0]["text"];
                } else {
                    $place = "";
                }

                if (isset($value["Title"][0]["text"])) {
                    $titulo = $value["Title"][0]["text"];

                } else {
                    $titulo = "";
                }

                if (isset($value["Call to Action"][0]["text"])){
                    $callEction = $value["Call to Action"][0]["text"];
                } else {
                    $callEction = "";
                }

                if (isset($value["Price"][0]["text"])){
                    $preco = $value["Price"][0]["text"];
                } else {
                    $preco = "";
                }

                if(isset($value["Price From"][0]["text"])) {
                    $price_from= @$value["Price From"][0]["text"];
                } else {
                    $price_from= "";
                }

                if(isset($value["Price Install"][0]["text"])) {
                    $price_install = $value["Price Install"][0]["text"];
                } else {
                    $price_install = "";
                }

                if(isset($value["Product"][0]["text"])) {
                    $produto = $value["Product"][0]["text"];
                } else {
                    $produto = "";
                }

                if(isset($value["Type"][0]["text"])) {
                    $type = $value["Type"][0]["text"];
                } else {
                    $type = "";
                }

                $string = $titulo.$produto.$target.$urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = $marca->id;
                    }
                }
                

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 3,
                        'categoria_id' => 7,
                        'marca_id' => $marca_id,
                        'loja_id' => $loja_id,
                        'tipo_anuncio_id' => '1',
                        'turno' => $turno,
                        'device' => 'Desktop',
                        'place' => $place,
                        'position' => $position,
                        'imagem' => $imagem,
                        'arquivo' => $name,
                        'target' => $target,
                        'type' => $type,
                        'titulo' => $titulo,
                        'produto' => $produto,
                        'detalhe' => '',
                        'call_action' => $callEction,
                        'preco' => $preco,
                        'price_from' => $price_from,
                        'price_install' => $price_install,
                        'url' => $urlTipo,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;

        //Brasil_Casasbahia_Desktop_Category_Organic Smartphones
        $requestCatOrg = $client->request('GET', 'https://extraction.import.io/query/extractor/2b5d8b52-e997-476c-9bf0-852b4df94345?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.casasbahia.com.br%2FTelefoneseCelulares%2FSmartphones%2F%3FFiltro%3DC38_C326',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestCatOrg =  json_decode($requestCatOrg->getBody(), true);
        $dadosCatOrg = $requestCatOrg['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestCatOrg['url'];

        foreach ( $dadosCatOrg as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Desktop_Category_Organic_Celular_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                }

                if (isset($value["Target URL"][0]["text"])){
                    $target = $value["Target URL"][0]["text"];
                } else {
                    $target = "";
                }

                if (isset($value["Place"][0]["text"])){
                    $place = $value["Place"][0]["text"];
                } else {
                    $place = "";
                }

                if (isset($value["Title"][0]["text"])) {
                    $titulo = $value["Title"][0]["text"];

                } else {
                    $titulo = "";
                }

                if (isset($value["Call to Action"][0]["text"])){
                    $callEction = $value["Call to Action"][0]["text"];
                } else {
                    $callEction = "";
                }

                if (isset($value["Price"][0]["text"])){
                    $preco = $value["Price"][0]["text"];
                } else {
                    $preco = "";
                }

                if(isset($value["Price From"][0]["text"])) {
                    $price_from= @$value["Price From"][0]["text"];
                } else {
                    $price_from= "";
                }

                if(isset($value["Price Install"][0]["text"])) {
                    $price_install = $value["Price Install"][0]["text"];
                } else {
                    $price_install = "";
                }

                if(isset($value["Product"][0]["text"])) {
                    $produto = $value["Product"][0]["text"];
                } else {
                    $produto = "";
                }

                if(isset($value["Type"][0]["text"])) {
                    $type = $value["Type"][0]["text"];
                } else {
                    $type = "";
                }

                $string = $titulo.$produto.$target. $urlTipo;
      

                foreach ($marcas as $marca) {

                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }
                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 4,
                        'categoria_id' => 1,
                        'marca_id' => $marca_id,
                        'loja_id' => $loja_id,
                        'tipo_anuncio_id' => '1',
                        'turno' => $turno,
                        'device' => 'Desktop',
                        'place' => $place,
                        'position' => $position,
                        'imagem' => $imagem,
                        'arquivo' => $name,
                        'target' => $target,
                        'type' => $type,
                        'titulo' => $titulo,
                        'produto' => $produto,
                        'detalhe' => '',
                        'call_action' => $callEction,
                        'preco' => $preco,
                        'price_from' => $price_from,
                        'price_install' => $price_install,
                        'url' => 311,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;

        //Brasil_Casasbahia_Desktop_Category_Organic Televisao
        $requestCatOrg = $client->request('GET', 'https://extraction.import.io/query/extractor/2b5d8b52-e997-476c-9bf0-852b4df94345?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.casasbahia.com.br%2Ftvseacessorios%2FTelevisores%2F%3FFiltro%3DC1_C2',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestCatOrg =  json_decode($requestCatOrg->getBody(), true);
        $dadosCatOrg = $requestCatOrg['extractorData']["data"];
        $position = 1;
        //    $urlTipo = $requestCatOrg['url'];
        foreach ( $dadosCatOrg as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                           $image = @file_get_contents($imagem);
                                        $image= base64_encode($image);
                                        $image = base64_decode($image);
                                        $name = "Brasil_".$lojaNome."_Desktop_Category_Organic_Tv_".$data.$turno.$position.".jpg";
                                        $im = @imagecreatefromstring($image);
                                        header("Content-type: image/jpg");
                                        @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                }

                if (isset($value["Target URL"][0]["text"])){
                    $target = $value["Target URL"][0]["text"];
                } else {
                    $target = "";
                }

                if (isset($value["Place"][0]["text"])){
                    $place = $value["Place"][0]["text"];
                } else {
                    $place = "";
                }

                if (isset($value["Title"][0]["text"])) {
                    $titulo = $value["Title"][0]["text"];

                } else {
                    $titulo = "";
                }

                if (isset($value["Call to Action"][0]["text"])){
                    $callEction = $value["Call to Action"][0]["text"];
                } else {
                    $callEction = "";
                }

                if (isset($value["Price"][0]["text"])){
                    $preco = $value["Price"][0]["text"];
                } else {
                    $preco = "";
                }

                if(isset($value["Price From"][0]["text"])) {
                    $price_from= @$value["Price From"][0]["text"];
                } else {
                    $price_from= "";
                }

                if(isset($value["Price Install"][0]["text"])) {
                    $price_install = $value["Price Install"][0]["text"];
                } else {
                    $price_install = "";
                }

                if(isset($value["Product"][0]["text"])) {
                    $produto = $value["Product"][0]["text"];
                } else {
                    $produto = "";
                }

                if(isset($value["Type"][0]["text"])) {
                    $type = $value["Type"][0]["text"];
                } else {
                    $type = "";
                }

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = $marca->id;
                    }
                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 4,
                        'categoria_id' => 2,
                        'marca_id' => $marca_id,
                        'loja_id' => $loja_id,
                        'tipo_anuncio_id' => '1',
                        'turno' => $turno,
                        'device' => 'Desktop',
                        'place' => $place,
                        'position' => $position,
                        'imagem' => $imagem,
                        'arquivo' => $name,
                        'target' => $target,
                        'type' => $type,
                        'titulo' => $titulo,
                        'produto' => $produto,
                        'detalhe' => '',
                        'call_action' => $callEction,
                        'preco' => $preco,
                        'price_from' => $price_from,
                        'price_install' => $price_install,
                        'url' => 88,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Brasil_Casasbahia_Desktop_Category_Organic Geladeira
        $requestCatOrg = $client->request('GET', 'https://extraction.import.io/query/extractor/2b5d8b52-e997-476c-9bf0-852b4df94345?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.casasbahia.com.br%2FEletrodomesticos%2FGeladeiraeRefrigerador%2F%3FFiltro%3DC13_C14',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestCatOrg =  json_decode($requestCatOrg->getBody(), true);
        $dadosCatOrg = $requestCatOrg['extractorData']["data"];
        $position = 1;
        //    $urlTipo = $requestCatOrg['url'];
        foreach ( $dadosCatOrg as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                                       $image = @file_get_contents($imagem);
                                        $image= base64_encode($image);
                                        $image = base64_decode($image);
                                        $name = "Brasil_".$lojaNome."_Desktop_Category_Organic_Geladeira_".$data.$turno.$position.".jpg";
                                        $im = @imagecreatefromstring($image);
                                        header("Content-type: image/jpg");
                                        @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                }

                if (isset($value["Target URL"][0]["text"])){
                    $target = $value["Target URL"][0]["text"];
                } else {
                    $target = "";
                }

                if (isset($value["Place"][0]["text"])){
                    $place = $value["Place"][0]["text"];
                } else {
                    $place = "";
                }

                if (isset($value["Title"][0]["text"])) {
                    $titulo = $value["Title"][0]["text"];

                } else {
                    $titulo = "";
                }

                if (isset($value["Call to Action"][0]["text"])){
                    $callEction = $value["Call to Action"][0]["text"];
                } else {
                    $callEction = "";
                }

                if (isset($value["Price"][0]["text"])){
                    $preco = $value["Price"][0]["text"];
                } else {
                    $preco = "";
                }

                if(isset($value["Price From"][0]["text"])) {
                    $price_from= @$value["Price From"][0]["text"];
                } else {
                    $price_from= "";
                }

                if(isset($value["Price Install"][0]["text"])) {
                    $price_install = $value["Price Install"][0]["text"];
                } else {
                    $price_install = "";
                }

                if(isset($value["Product"][0]["text"])) {
                    $produto = $value["Product"][0]["text"];
                } else {
                    $produto = "";
                }

                if(isset($value["Type"][0]["text"])) {
                    $type = $value["Type"][0]["text"];
                } else {
                    $type = "";
                }

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = $marca->id;
                    }
                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 4,
                        'categoria_id' => 3,
                        'marca_id' => $marca_id,
                        'loja_id' => $loja_id,
                        'tipo_anuncio_id' => '1',
                        'turno' => $turno,
                        'device' => 'Desktop',
                        'place' => $place,
                        'position' => $position,
                        'imagem' => $imagem,
                        'arquivo' => $name,
                        'target' => $target,
                        'type' => $type,
                        'titulo' => $titulo,
                        'produto' => $produto,
                        'detalhe' => '',
                        'call_action' => $callEction,
                        'preco' => $preco,
                        'price_from' => $price_from,
                        'price_install' => $price_install,
                        'url' => 5,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;

        //Brasil_Casasbahia_Desktop_Category_Organic Maquina de Lavar
              $requestCatOrg = $client->request('GET', 'https://extraction.import.io/query/extractor/2b5d8b52-e997-476c-9bf0-852b4df94345?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.casasbahia.com.br%2Ftvseacessorios%2Fmaquinadelavar%2F%3FFiltro%3DC13_C24',
                  [
                      'headers' => [
                          'Accept' => 'application/json',
                          'Content-type'=> 'application/json',
                          'Accept-Encoding' => 'gzip'
                      ]
                  ]);

              $requestCatOrg =  json_decode($requestCatOrg->getBody(), true);
              $dadosCatOrg = $requestCatOrg['extractorData']["data"];
              $position = 1;
              //    $urlTipo = $requestCatOrg['url'];
              foreach ( $dadosCatOrg as $dado):

                  foreach ($dado["group"]  as $value):
                      if (isset($value["Image"][0]["src"])) {

                          $imagem = $value["Image"][0]["src"];
                                 $image = @file_get_contents($imagem);
                                              $image= base64_encode($image);
                                              $image = base64_decode($image);
                                              $name = "Brasil_".$lojaNome."_Desktop_Category_Organic_Maquina_Lavar".$data.$turno.$position.".jpg";
                                              $im = @imagecreatefromstring($image);
                                              header("Content-type: image/jpg");
                                              @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                      } else {
                          $imagem = "";
                      }

                      if (isset($value["Target URL"][0]["text"])){
                          $target = $value["Target URL"][0]["text"];
                      } else {
                          $target = "";
                      }

                      if (isset($value["Place"][0]["text"])){
                          $place = $value["Place"][0]["text"];
                      } else {
                          $place = "";
                      }

                      if (isset($value["Title"][0]["text"])) {
                          $titulo = $value["Title"][0]["text"];

                      } else {
                          $titulo = "";
                      }

                      if (isset($value["Call to Action"][0]["text"])){
                          $callEction = $value["Call to Action"][0]["text"];
                      } else {
                          $callEction = "";
                      }

                      if (isset($value["Price"][0]["text"])){
                          $preco = $value["Price"][0]["text"];
                      } else {
                          $preco = "";
                      }

                      if(isset($value["Price From"][0]["text"])) {
                          $price_from= @$value["Price From"][0]["text"];
                      } else {
                          $price_from= "";
                      }

                      if(isset($value["Price Install"][0]["text"])) {
                          $price_install = $value["Price Install"][0]["text"];
                      } else {
                          $price_install = "";
                      }

                      if(isset($value["Product"][0]["text"])) {
                          $produto = $value["Product"][0]["text"];
                      } else {
                          $produto = "";
                      }

                      if(isset($value["Type"][0]["text"])) {
                          $type = $value["Type"][0]["text"];
                      } else {
                          $type = "";
                      }

                      $string = $titulo.$produto.$target. $urlTipo;

                      foreach ($marcas as $marca) {
                          $buscaMarca = strstr($string, $marca->descricao);
                          if($buscaMarca){
                              $marca_id = $marca->id;
                          }
                      }

                      DB::table('scraps')->insertGetId(
                          [
                              'pais_id' => $pais_id,
                              'tipo_pagina_id' => 4,
                              'categoria_id' => 4,
                              'marca_id' => $marca_id,
                              'loja_id' => $loja_id,
                              'tipo_anuncio_id' => '1',
                              'turno' => $turno,
                              'device' => 'Desktop',
                              'place' => $place,
                              'position' => $position,
                              'imagem' => $imagem,
                              'arquivo' => $name,
                              'target' => $target,
                              'type' => $type,
                              'titulo' => $titulo,
                              'produto' => $produto,
                              'detalhe' => '',
                              'call_action' => $callEction,
                              'preco' => $preco,
                              'price_from' => $price_from,
                              'price_install' => $price_install,
                              'url' => 133,
                              'detalhe_tipo_anuncio' => '',
                              'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s')
                          ]);
                      $position ++;
                  endforeach;
              endforeach;


              //Brasil_Casasbahia_Desktop_Homepage_Carousel
              $requestDeskHomeCarousel = $client->request('GET', 'https://data.import.io/extractor/e4e047b5-f604-48b7-a9f7-3d6eef4967a1/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
                  [
                      'headers' => [
                          'Accept' => 'application/json',
                          'Content-type'=> 'application/json',
                          'Accept-Encoding' => 'gzip'
                      ]
                  ]);

              $requestDeskHomeCarousel =  json_decode($requestDeskHomeCarousel->getBody(), true);
              $dadosDeskHomeCarousel = $requestDeskHomeCarousel["result"]['extractorData']["data"];
              $position = 1;
              $urlTipo = $requestDeskHomeCarousel['url'];

              foreach ( $dadosDeskHomeCarousel as $dado):

                  foreach ($dado["group"]  as $value):
                      if (isset($value["Image"][0]["src"])) {
                          if($value["Image"][0]["src"] != "http://www.casasbahia.com.br/undefined"){

                              $imagem = $value["Image"][0]["src"];
                              $image = @file_get_contents($imagem);
                              $image= base64_encode($image);
                              $image = base64_decode($image);
                              $name = "Brasil_".$lojaNome."_Desktop_Homepage_Carousel_".$data.$turno.$position.".png";
                              $im = @imagecreatefromstring($image);
                              header("Content-type: image/png");
                              @imagepng($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                          } else {
                              $imagem = "";
                          }


                      } else {
                          $imagem = "";
                      }

                      if (isset($value["Target URL"][0]["text"])){
                          $target = $value["Target URL"][0]["text"];
                      } else {
                          $target = "";
                      }

                      if (isset($value["Place"][0]["text"])){
                          $place = $value["Place"][0]["text"];
                      } else {
                          $place = "";
                      }

                      if (isset($value["Title"][0]["text"])) {
                          $titulo = $value["Title"][0]["text"];

                      } else {
                          $titulo = "";
                      }

                      if (isset($value["Call to Action"][0]["text"])){
                          $callEction = $value["Call to Action"][0]["text"];
                      } else {
                          $callEction = "";
                      }

                      if (isset($value["Price"][0]["text"])){
                          $preco = $value["Price"][0]["text"];
                      } else {
                          $preco = "";
                      }

                      if(isset($value["Price From"][0]["text"])) {
                          $price_from= @$value["Price From"][0]["text"];
                      } else {
                          $price_from= "";
                      }

                      if(isset($value["Price Install"][0]["text"])) {
                          $price_install = $value["Price Install"][0]["text"];
                      } else {
                          $price_install = "";
                      }

                      if(isset($value["Product"][0]["text"])) {
                          $produto = $value["Product"][0]["text"];
                      } else {
                          $produto = "";
                      }

                      if(isset($value["Type"][0]["text"])) {
                          $type = $value["Type"][0]["text"];
                      } else {
                          $type = "";
                      }

                      $string = $titulo.$produto.$target. $urlTipo;

                      foreach ($marcas as $marca) {
                          $buscaMarca = strstr($string, $marca->descricao);
                          if($buscaMarca){
                              $marca_id = $marca->id;
                          }
                      }

                      DB::table('scraps')->insertGetId(
                          [
                              'pais_id' => $pais_id,
                              'tipo_pagina_id' => 2,
                              'categoria_id' => 7,
                              'marca_id' => $marca_id,
                              'loja_id' => $loja_id,
                              'tipo_anuncio_id' => '1',
                              'turno' => $turno,
                              'device' => 'Desktop',
                              'place' => $place,
                              'position' => $position,
                              'imagem' => $imagem,
                              'arquivo' => $name,
                              'target' => $target,
                              'type' => $type,
                              'titulo' => $titulo,
                              'produto' => $produto,
                              'detalhe' => '',
                              'call_action' => $callEction,
                              'preco' => $preco,
                              'price_from' => $price_from,
                              'price_install' => $price_install,
                              'url' => $urlTipo,
                              'detalhe_tipo_anuncio' => '',
                              'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s')
                          ]);
                      $position ++;
                  endforeach;
              endforeach;


              //Brasil_Casasbahia_Desktop_Category_Carousel
              $requestCarousel = $client->request('GET', 'https://extraction.import.io/query/extractor/2b5d8b52-e997-476c-9bf0-852b4df94345?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.casasbahia.com.br%2FTelefoneseCelulares%2FSmartphones%2F%3FFiltro%3DC38_C326',
                  [
                      'headers' => [
                          'Accept' => 'application/json',
                          'Content-type'=> 'application/json',
                          'Accept-Encoding' => 'gzip'
                      ]
                  ]);

              $requestCarousel =  json_decode($requestCarousel->getBody(), true);
              $dadosCarousel = $requestCarousel['extractorData']["data"];
              $position = 1;
              $urlTipo = $requestCarousel['url'];

              foreach ( $dadosCarousel as $dado):

                  foreach ($dado["group"]  as $value):
                      if (isset($value["Image"][0]["src"])) {

                          $imagem = $value["Image"][0]["src"];
                          $image = @file_get_contents($imagem);
                          $image= base64_encode($image);
                          $image = base64_decode($image);
                          $name = "Brasil_".$lojaNome."_Desktop_Category_Carousel_".$data.$turno.$position.".jpg";
                          $im = @imagecreatefromstring($image);
                          header("Content-type: image/jpg");
                          @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                      } else {
                          $imagem = "";
                      }

                      if (isset($value["Target URL"][0]["text"])){
                          $target = $value["Target URL"][0]["text"];
                      } else {
                          $target = "";
                      }

                      if (isset($value["Place"][0]["text"])){
                          $place = $value["Place"][0]["text"];
                      } else {
                          $place = "";
                      }

                      if (isset($value["Title"][0]["text"])) {
                          $titulo = $value["Title"][0]["text"];

                      } else {
                          $titulo = "";
                      }

                      if (isset($value["Call to Action"][0]["text"])){
                          $callEction = $value["Call to Action"][0]["text"];
                      } else {
                          $callEction = "";
                      }

                      if (isset($value["Price"][0]["text"])){
                          $preco = $value["Price"][0]["text"];
                      } else {
                          $preco = "";
                      }

                      if(isset($value["Price From"][0]["text"])) {
                          $price_from= @$value["Price From"][0]["text"];
                      } else {
                          $price_from= "";
                      }

                      if(isset($value["Price Install"][0]["text"])) {
                          $price_install = $value["Price Install"][0]["text"];
                      } else {
                          $price_install = "";
                      }

                      if(isset($value["Product"][0]["text"])) {
                          $produto = $value["Product"][0]["text"];
                      } else {
                          $produto = "";
                      }

                      if(isset($value["Type"][0]["text"])) {
                          $type = $value["Type"][0]["text"];
                      } else {
                          $type = "";
                      }

                      $string = $titulo.$produto.$target. $urlTipo;

                      foreach ($marcas as $marca) {
                          $buscaMarca = strstr($string, $marca->descricao);
                          if($buscaMarca){
                              $marca_id = $marca->id;
                          }
                      }

                      DB::table('scraps')->insertGetId(
                          [
                              'pais_id' => $pais_id,
                              'tipo_pagina_id' => 2,
                              'categoria_id' => 7,
                              'marca_id' => $marca_id,
                              'loja_id' => $loja_id,
                              'tipo_anuncio_id' => '1',
                              'turno' => $turno,
                              'device' => 'Desktop',
                              'place' => $place,
                              'position' => $position,
                              'imagem' => $imagem,
                              'arquivo' => $name,
                              'target' => $target,
                              'type' => $type,
                              'titulo' => $titulo,
                              'produto' => $produto,
                              'detalhe' => '',
                              'call_action' => $callEction,
                              'preco' => $preco,
                              'price_from' => $price_from,
                              'price_install' => $price_install,
                              'url' => $urlTipo,
                              'detalhe_tipo_anuncio' => '',
                              'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s')
                          ]);
                      $position ++;
                  endforeach;
              endforeach;


              //Brasil_Casasbahia_Desktop_Homepage_Organic
              $requestHomeOrganic = $client->request('GET', 'https://data.import.io/extractor/3ef99162-8b6f-4c37-b3f1-ea2566347c0d/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
                  [
                      'headers' => [
                          'Accept' => 'application/json',
                          'Content-type'=> 'application/json',
                          'Accept-Encoding' => 'gzip'
                      ]
                  ]);

              $requestHomeOrganic =  json_decode($requestHomeOrganic->getBody(), true);
              $dadosHome = $requestHomeOrganic['result']['extractorData']["data"];
              $position = 1;
              $urlTipo = $requestHomeOrganic['url'];

              foreach ( $dadosHome as $dado):

                  foreach ($dado["group"]  as $value):

                      if (isset($value["Image"][0]["src"])) {

                          $imagem = $value["Image"][0]["src"];
                          $image = @file_get_contents($imagem);
                          $image= base64_encode($image);
                          $image = base64_decode($image);
                          $name = "Brasil_".$lojaNome."_Desktop_Homepage_Organic_".$data.$turno.$position.".jpg";
                          $im = @imagecreatefromstring($image);
                          header("Content-type: image/jpg");
                          @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                      } else {
                          $imagem = "";
                      }

                      if (isset($value["Target URL"][0]["text"])){
                          $target = $value["Target URL"][0]["text"];
                      } else {
                          $target = "";
                      }

                      if (isset($value["Place"][0]["text"])){
                          $place = $value["Place"][0]["text"];
                      } else {
                          $place = "";
                      }

                      if (isset($value["Title"][0]["text"])) {
                          $titulo = $value["Title"][0]["text"];

                      } else {
                          $titulo = "";
                      }

                      if (isset($value["Call to Action"][0]["text"])){
                          $callEction = $value["Call to Action"][0]["text"];
                      } else {
                          $callEction = "";
                      }

                      if (isset($value["Price"][0]["text"])){
                          $preco = $value["Price"][0]["text"];
                      } else {
                          $preco = "";
                      }

                      if(isset($value["Price From"][0]["text"])) {
                          $price_from= @$value["Price From"][0]["text"];
                      } else {
                          $price_from= "";
                      }

                      if(isset($value["Price Install"][0]["text"])) {
                          $price_install = $value["Price Install"][0]["text"];
                      } else {
                          $price_install = "";
                      }

                      if(isset($value["Product"][0]["text"])) {
                          $produto = $value["Product"][0]["text"];
                      } else {
                          $produto = "";
                      }

                      if(isset($value["Type"][0]["text"])) {
                          $type = $value["Type"][0]["text"];
                      } else {
                          $type = "";
                      }

                      $string = $titulo.$produto.$target.$urlTipo;

                      foreach ($marcas as $marca) {
                          $buscaMarca = strstr($string, $marca->descricao);
                          if($buscaMarca){
                              $marca_id = $marca->id;
                          }
                      }

                      DB::table('scraps')->insertGetId(
                          [
                              'pais_id' => $pais_id,
                              'tipo_pagina_id' => 1,
                              'categoria_id' => 7,
                              'marca_id' => $marca_id,
                              'loja_id' => $loja_id,
                              'tipo_anuncio_id' => '1',
                              'turno' => $turno,
                              'device' => 'Desktop',
                              'place' => $place,
                              'position' => $position,
                              'imagem' => $imagem,
                              'arquivo' => $name,
                              'target' => $target,
                              'type' => $type,
                              'titulo' => $titulo,
                              'produto' => $produto,
                              'detalhe' => '',
                              'call_action' => $callEction,
                              'preco' => $preco,
                              'price_from' => $price_from,
                              'price_install' => $price_install,
                              'url' => $urlTipo,
                              'detalhe_tipo_anuncio' => '',
                              'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s')
                          ]);
                      $position ++;
                  endforeach;
              endforeach;

              //Brasil_Casasbahia_Mobile_Category_Organic celular
              $requestMobileCategory = $client->request('GET', 'https://extraction.import.io/query/extractor/4baf0a1f-5b3b-4153-acca-d603d92f55bf?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fm.casasbahia.com.br%2F%23%2Fdepartamentos%2F38_326',
                  [
                      'headers' => [
                          'Accept' => 'application/json',
                          'Content-type'=> 'application/json',
                          'Accept-Encoding' => 'gzip'
                      ]
                  ]);

              $requestMobileCategory =  json_decode($requestMobileCategory->getBody(), true);
              $dadosMobileCategory = $requestMobileCategory['extractorData']["data"];
              $position = 1;
              $urlTipo = $requestMobileCategory['url'];

              foreach ( $dadosMobileCategory as $dado):

                  foreach ($dado["group"]  as $value):
                      if (isset($value["Image"][0]["src"])) {

                          $imagem = $value["Image"][0]["src"];
                          $image = @file_get_contents($imagem);
                          $image= base64_encode($image);
                          $image = base64_decode($image);
                          $name = "Brasil_".$lojaNome."_Mobile_Category_Organic_Celular_".$data.$turno.$position.".jpg";
                          $im = @imagecreatefromstring($image);
                          header("Content-type: image/jpg");
                          @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                      } else {
                          $imagem = "";
                      }

                      if (isset($value["Target URL"][0]["text"])){
                          $target = $value["Target URL"][0]["text"];
                      } else {
                          $target = "";
                      }

                      if (isset($value["Place"][0]["text"])){
                          $place = $value["Place"][0]["text"];
                      } else {
                          $place = "";
                      }

                      if (isset($value["Title"][0]["text"])) {
                          $titulo = $value["Title"][0]["text"];

                      } else {
                          $titulo = "";
                      }

                      if (isset($value["Call to Action"][0]["text"])){
                          $callEction = $value["Call to Action"][0]["text"];
                      } else {
                          $callEction = "";
                      }

                      if (isset($value["Price"][0]["text"])){
                          $preco = $value["Price"][0]["text"];
                      } else {
                          $preco = "";
                      }

                      if(isset($value["Price From"][0]["text"])) {
                          $price_from= @$value["Price From"][0]["text"];
                      } else {
                          $price_from= "";
                      }

                      if(isset($value["Price Install"][0]["text"])) {
                          $price_install = $value["Price Install"][0]["text"];
                      } else {
                          $price_install = "";
                      }

                      if(isset($value["Product"][0]["text"])) {
                          $produto = $value["Product"][0]["text"];
                      } else {
                          $produto = "";
                      }

                      if(isset($value["Type"][0]["text"])) {
                          $type = $value["Type"][0]["text"];
                      } else {
                          $type = "";
                      }

                      $string = $titulo.$produto.$target. $urlTipo;

                      foreach ($marcas as $marca) {
                          $buscaMarca = strstr($string, $marca->descricao);
                          if($buscaMarca){
                              $marca_id = $marca->id;
                          }
                      }

                      DB::table('scraps')->insertGetId(
                          [
                              'pais_id' => $pais_id,
                              'tipo_pagina_id' => 4,
                              'categoria_id' => 1,
                              'marca_id' => $marca_id,
                              'loja_id' => $loja_id,
                              'tipo_anuncio_id' => '1',
                              'turno' => $turno,
                              'device' => 'Mobile',
                              'place' => $place,
                              'position' => $position,
                              'imagem' => $imagem,
                              'arquivo' => $name,
                              'target' => $target,
                              'type' => $type,
                              'titulo' => $titulo,
                              'produto' => $produto,
                              'detalhe' => '',
                              'call_action' => $callEction,
                              'preco' => $preco,
                              'price_from' => $price_from,
                              'price_install' => $price_install,
                              'url' => 61,
                              'detalhe_tipo_anuncio' => '',
                              'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s')
                          ]);
                      $position ++;
                  endforeach;
              endforeach;


        //Brasil_Casasbahia_Mobile_Category_Organic Tv
        $requestMobileCategory = $client->request('GET', 'https://extraction.import.io/query/extractor/4baf0a1f-5b3b-4153-acca-d603d92f55bf?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fm.casasbahia.com.br%2F%23%2Fdepartamentos%2F1_2',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestMobileCategory =  json_decode($requestMobileCategory->getBody(), true);
        $dadosMobileCategory = $requestMobileCategory['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestMobileCategory['url'];

        foreach ( $dadosMobileCategory as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Mobile_Category_Organic_Tv_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                }

                if (isset($value["Target URL"][0]["text"])){
                    $target = $value["Target URL"][0]["text"];
                } else {
                    $target = "";
                }

                if (isset($value["Place"][0]["text"])){
                    $place = $value["Place"][0]["text"];
                } else {
                    $place = "";
                }

                if (isset($value["Title"][0]["text"])) {
                    $titulo = $value["Title"][0]["text"];

                } else {
                    $titulo = "";
                }

                if (isset($value["Call to Action"][0]["text"])){
                    $callEction = $value["Call to Action"][0]["text"];
                } else {
                    $callEction = "";
                }

                if (isset($value["Price"][0]["text"])){
                    $preco = $value["Price"][0]["text"];
                } else {
                    $preco = "";
                }

                if(isset($value["Price From"][0]["text"])) {
                    $price_from= @$value["Price From"][0]["text"];
                } else {
                    $price_from= "";
                }

                if(isset($value["Price Install"][0]["text"])) {
                    $price_install = $value["Price Install"][0]["text"];
                } else {
                    $price_install = "";
                }

                if(isset($value["Product"][0]["text"])) {
                    $produto = $value["Product"][0]["text"];
                } else {
                    $produto = "";
                }

                if(isset($value["Type"][0]["text"])) {
                    $type = $value["Type"][0]["text"];
                } else {
                    $type = "";
                }

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = $marca->id;
                    }
                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 4,
                        'categoria_id' => 2,
                        'marca_id' => $marca_id,
                        'loja_id' => $loja_id,
                        'tipo_anuncio_id' => '1',
                        'turno' => $turno,
                        'device' => 'Mobile',
                        'place' => $place,
                        'position' => $position,
                        'imagem' => $imagem,
                        'arquivo' => $name,
                        'target' => $target,
                        'type' => $type,
                        'titulo' => $titulo,
                        'produto' => $produto,
                        'detalhe' => '',
                        'call_action' => $callEction,
                        'preco' => $preco,
                        'price_from' => $price_from,
                        'price_install' => $price_install,
                        'url' => 107,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Brasil_Casasbahia_Mobile_Category_Organic Geladeira
        $requestMobileCategory = $client->request('GET', 'https://extraction.import.io/query/extractor/4baf0a1f-5b3b-4153-acca-d603d92f55bf?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fm.casasbahia.com.br%2F%23%2Fdepartamentos%2F13_14',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestMobileCategory =  json_decode($requestMobileCategory->getBody(), true);
        $dadosMobileCategory = $requestMobileCategory['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestMobileCategory['url'];

        foreach ( $dadosMobileCategory as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Mobile_Category_Organic_Geladeira_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                }

                if (isset($value["Target URL"][0]["text"])){
                    $target = $value["Target URL"][0]["text"];
                } else {
                    $target = "";
                }

                if (isset($value["Place"][0]["text"])){
                    $place = $value["Place"][0]["text"];
                } else {
                    $place = "";
                }

                if (isset($value["Title"][0]["text"])) {
                    $titulo = $value["Title"][0]["text"];

                } else {
                    $titulo = "";
                }

                if (isset($value["Call to Action"][0]["text"])){
                    $callEction = $value["Call to Action"][0]["text"];
                } else {
                    $callEction = "";
                }

                if (isset($value["Price"][0]["text"])){
                    $preco = $value["Price"][0]["text"];
                } else {
                    $preco = "";
                }

                if(isset($value["Price From"][0]["text"])) {
                    $price_from= @$value["Price From"][0]["text"];
                } else {
                    $price_from= "";
                }

                if(isset($value["Price Install"][0]["text"])) {
                    $price_install = $value["Price Install"][0]["text"];
                } else {
                    $price_install = "";
                }

                if(isset($value["Product"][0]["text"])) {
                    $produto = $value["Product"][0]["text"];
                } else {
                    $produto = "";
                }

                if(isset($value["Type"][0]["text"])) {
                    $type = $value["Type"][0]["text"];
                } else {
                    $type = "";
                }

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = $marca->id;
                    }
                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 4,
                        'categoria_id' => 3,
                        'marca_id' => $marca_id,
                        'loja_id' => $loja_id,
                        'tipo_anuncio_id' => '1',
                        'turno' => $turno,
                        'device' => 'Mobile',
                        'place' => $place,
                        'position' => $position,
                        'imagem' => $imagem,
                        'arquivo' => $name,
                        'target' => $target,
                        'type' => $type,
                        'titulo' => $titulo,
                        'produto' => $produto,
                        'detalhe' => '',
                        'call_action' => $callEction,
                        'preco' => $preco,
                        'price_from' => $price_from,
                        'price_install' => $price_install,
                        'url' => 22,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Brasil_Casasbahia_Mobile_Category_Organic Maquina Lavar
        $requestMobileCategory = $client->request('GET', 'https://extraction.import.io/query/extractor/4baf0a1f-5b3b-4153-acca-d603d92f55bf?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fm.casasbahia.com.br%2F%23%2Fdepartamentos%2F13_24',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestMobileCategory =  json_decode($requestMobileCategory->getBody(), true);
        $dadosMobileCategory = $requestMobileCategory['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestMobileCategory['url'];

        foreach ( $dadosMobileCategory as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Mobile_Category_Organic_Maquina_lavar_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                }

                if (isset($value["Target URL"][0]["text"])){
                    $target = $value["Target URL"][0]["text"];
                } else {
                    $target = "";
                }

                if (isset($value["Place"][0]["text"])){
                    $place = $value["Place"][0]["text"];
                } else {
                    $place = "";
                }

                if (isset($value["Title"][0]["text"])) {
                    $titulo = $value["Title"][0]["text"];

                } else {
                    $titulo = "";
                }

                if (isset($value["Call to Action"][0]["text"])){
                    $callEction = $value["Call to Action"][0]["text"];
                } else {
                    $callEction = "";
                }

                if (isset($value["Price"][0]["text"])){
                    $preco = $value["Price"][0]["text"];
                } else {
                    $preco = "";
                }

                if(isset($value["Price From"][0]["text"])) {
                    $price_from= @$value["Price From"][0]["text"];
                } else {
                    $price_from= "";
                }

                if(isset($value["Price Install"][0]["text"])) {
                    $price_install = $value["Price Install"][0]["text"];
                } else {
                    $price_install = "";
                }

                if(isset($value["Product"][0]["text"])) {
                    $produto = $value["Product"][0]["text"];
                } else {
                    $produto = "";
                }

                if(isset($value["Type"][0]["text"])) {
                    $type = $value["Type"][0]["text"];
                } else {
                    $type = "";
                }

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = $marca->id;
                    }
                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 4,
                        'categoria_id' => 4,
                        'marca_id' => $marca_id,
                        'loja_id' => $loja_id,
                        'tipo_anuncio_id' => '1',
                        'turno' => $turno,
                        'device' => 'Mobile',
                        'place' => $place,
                        'position' => $position,
                        'imagem' => $imagem,
                        'arquivo' => $name,
                        'target' => $target,
                        'type' => $type,
                        'titulo' => $titulo,
                        'produto' => $produto,
                        'detalhe' => '',
                        'call_action' => $callEction,
                        'preco' => $preco,
                        'price_from' => $price_from,
                        'price_install' => $price_install,
                        'url' => 149,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Brasil_Casasbahia_Desktop_Category_Organic Maquina Lavar
        $requestMobileCategory = $client->request('GET', 'https://extraction.import.io/query/extractor/2b5d8b52-e997-476c-9bf0-852b4df94345?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.casasbahia.com.br%2FEletrodomesticos%2Fmaquinadelavar%2F%3FFiltro%3DC13_C24',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestMobileCategory =  json_decode($requestMobileCategory->getBody(), true);
        $dadosMobileCategory = $requestMobileCategory['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestMobileCategory['url'];

        foreach ( $dadosMobileCategory as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Desktop_Category_Organic_Maquina_lavar_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                }

                if (isset($value["Target URL"][0]["text"])){
                    $target = $value["Target URL"][0]["text"];
                } else {
                    $target = "";
                }

                if (isset($value["Place"][0]["text"])){
                    $place = $value["Place"][0]["text"];
                } else {
                    $place = "";
                }

                if (isset($value["Title"][0]["text"])) {
                    $titulo = $value["Title"][0]["text"];

                } else {
                    $titulo = "";
                }

                if (isset($value["Call to Action"][0]["text"])){
                    $callEction = $value["Call to Action"][0]["text"];
                } else {
                    $callEction = "";
                }

                if (isset($value["Price"][0]["text"])){
                    $preco = $value["Price"][0]["text"];
                } else {
                    $preco = "";
                }

                if(isset($value["Price From"][0]["text"])) {
                    $price_from= @$value["Price From"][0]["text"];
                } else {
                    $price_from= "";
                }

                if(isset($value["Price Install"][0]["text"])) {
                    $price_install = $value["Price Install"][0]["text"];
                } else {
                    $price_install = "";
                }

                if(isset($value["Product"][0]["text"])) {
                    $produto = $value["Product"][0]["text"];
                } else {
                    $produto = "";
                }

                if(isset($value["Type"][0]["text"])) {
                    $type = $value["Type"][0]["text"];
                } else {
                    $type = "";
                }

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = $marca->id;
                    }
                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 4,
                        'categoria_id' => 4,
                        'marca_id' => $marca_id,
                        'loja_id' => $loja_id,
                        'tipo_anuncio_id' => '1',
                        'turno' => $turno,
                        'device' => 'Desktop',
                        'place' => $place,
                        'position' => $position,
                        'imagem' => $imagem,
                        'arquivo' => $name,
                        'target' => $target,
                        'type' => $type,
                        'titulo' => $titulo,
                        'produto' => $produto,
                        'detalhe' => '',
                        'call_action' => $callEction,
                        'preco' => $preco,
                        'price_from' => $price_from,
                        'price_install' => $price_install,
                        'url' => 132,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;




        //Brasil_Casasbahia_Mobile_Homepage_Carousel
              $requestMobileHomeCarousel = $client->request('GET', 'https://data.import.io/extractor/8f7d2e3f-b7de-432b-a2b8-d6365fd95e69/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
                  [
                      'headers' => [
                          'Accept' => 'application/json',
                          'Content-type'=> 'application/json',
                          'Accept-Encoding' => 'gzip'
                      ]
                  ]);

              $requestMobileHomeCarousel =  json_decode($requestMobileHomeCarousel->getBody(), true);
              $daddosleHomeCarousel = $requestMobileHomeCarousel['result']['extractorData']["data"];
              $position = 1;
              $urlTipo = $requestMobileHomeCarousel['url'];

              foreach ( $daddosleHomeCarousel as $dado):

                  foreach ($dado["group"]  as $value):
                      if (isset($value["Image"][0]["src"])) {

                          $imagem = $value["Image"][0]["src"];
                          $image = @file_get_contents($imagem);
                          $image = base64_encode($image);
                          $image = base64_decode($image);
                          $name = "Brasil_".$lojaNome."_Mobile_Homepage_Carousel_".$data.$turno.$position.".jpg";
                          $im = @imagecreatefromstring($image);
                          header("Content-type: image/jpg");
                          @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                      } else {
                          $imagem = "";
                      }

                      if (isset($value["Target URL"][0]["text"])){
                          $target = $value["Target URL"][0]["text"];
                      } else {
                          $target = "";
                      }

                      if (isset($value["Place"][0]["text"])){
                          $place = $value["Place"][0]["text"];
                      } else {
                          $place = "";
                      }

                      if (isset($value["Title"][0]["text"])) {
                          $titulo = $value["Title"][0]["text"];

                      } else {
                          $titulo = "";
                      }

                      if (isset($value["Call to Action"][0]["text"])){
                          $callEction = $value["Call to Action"][0]["text"];
                      } else {
                          $callEction = "";
                      }

                      if (isset($value["Price"][0]["text"])){
                          $preco = $value["Price"][0]["text"];
                      } else {
                          $preco = "";
                      }

                      if(isset($value["Price From"][0]["text"])) {
                          $price_from= @$value["Price From"][0]["text"];
                      } else {
                          $price_from= "";
                      }

                      if(isset($value["Price Install"][0]["text"])) {
                          $price_install = $value["Price Install"][0]["text"];
                      } else {
                          $price_install = "";
                      }

                      if(isset($value["Product"][0]["text"])) {
                          $produto = $value["Product"][0]["text"];
                      } else {
                          $produto = "";
                      }

                      if(isset($value["Type"][0]["text"])) {
                          $type = $value["Type"][0]["text"];
                      } else {
                          $type = "";
                      }

                      $string = $titulo.$produto.$target. $urlTipo;

                      foreach ($marcas as $marca) {
                          $buscaMarca = strstr($string, $marca->descricao);
                          if($buscaMarca){
                              $marca_id = $marca->id;
                          }
                      }

                      DB::table('scraps')->insertGetId(
                          [
                              'pais_id' => $pais_id,
                              'tipo_pagina_id' => 2,
                              'categoria_id' => 7,
                              'marca_id' => $marca_id,
                              'loja_id' => $loja_id,
                              'tipo_anuncio_id' => '1',
                              'turno' => $turno,
                              'device' => 'Mobile',
                              'place' => $place,
                              'position' => $position,
                              'imagem' => $imagem,
                              'arquivo' => $name,
                              'target' => $target,
                              'type' => $type,
                              'titulo' => $titulo,
                              'produto' => $produto,
                              'detalhe' => '',
                              'call_action' => $callEction,
                              'preco' => $preco,
                              'price_from' => $price_from,
                              'price_install' => $price_install,
                              'url' => $urlTipo,
                              'detalhe_tipo_anuncio' => '',
                              'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s')
                          ]);
                      $position ++;


                  endforeach;
              endforeach;


              //Brasil_Casasbahia_Mobile_Homepage_Ads
              $requestMobileHomeAds = $client->request('GET', 'https://data.import.io/extractor/38b05d06-0d41-408d-884d-34f4ae8200b1/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
                  [
                      'headers' => [
                          'Accept' => 'application/json',
                          'Content-type'=> 'application/json',
                          'Accept-Encoding' => 'gzip'
                      ]
                  ]);

              $requestMobileHomeAds =  json_decode($requestMobileHomeAds->getBody(), true);
              $daddosMobileHomeAds = $requestMobileHomeAds['result']['extractorData']["data"];
              $position = 1;
              $urlTipo = $requestMobileHomeAds['url'];

              foreach ( $daddosMobileHomeAds as $dado):

                  foreach ($dado["group"]  as $value):

                      $imagem = $value["Image"][0]["src"];
                      $image = @file_get_contents($imagem);
                      $image= base64_encode($image);
                      $image = base64_decode($image);
                      $name = "Brasil_".$lojaNome."_Mobile_Homepage_Ads_".$data.$turno.$position.".png";
                      $im = @imagecreatefromstring($image);
                      header("Content-type: image/png");
                      @imagepng($im, "/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                      if (isset($value["Target URL"][0]["text"])){
                          $target = $value["Target URL"][0]["text"];
                      } else {
                          $target = "";
                      }

                      if (isset($value["Place"][0]["text"])){
                          $place = $value["Place"][0]["text"];
                      } else {
                          $place = "";
                      }

                      if (isset($value["Title"][0]["text"])) {
                          $titulo = $value["Title"][0]["text"];

                      } else {
                          $titulo = "";
                      }

                      if (isset($value["Call to Action"][0]["text"])){
                          $callEction = $value["Call to Action"][0]["text"];
                      } else {
                          $callEction = "";
                      }

                      if (isset($value["Price"][0]["text"])){
                          $preco = $value["Price"][0]["text"];
                      } else {
                          $preco = "";
                      }

                      if(isset($value["Price From"][0]["text"])) {
                          $price_from= @$value["Price From"][0]["text"];
                      } else {
                          $price_from= "";
                      }

                      if(isset($value["Price Install"][0]["text"])) {
                          $price_install = $value["Price Install"][0]["text"];
                      } else {
                          $price_install = "";
                      }

                      if(isset($value["Product"][0]["text"])) {
                          $produto = $value["Product"][0]["text"];
                      } else {
                          $produto = "";
                      }

                      if(isset($value["Type"][0]["text"])) {
                          $type = $value["Type"][0]["text"];
                      } else {
                          $type = "";
                      }

                      $string = $titulo.$produto.$target. $urlTipo;

                      foreach ($marcas as $marca) {
                          $buscaMarca = strstr($string, $marca->descricao);
                          if($buscaMarca){
                              $marca_id = $marca->id;
                          }
                      }

                      DB::table('scraps')->insertGetId(
                          [
                              'pais_id' => $pais_id,
                              'tipo_pagina_id' => 3,
                              'categoria_id' => 7,
                              'marca_id' => $marca_id,
                              'loja_id' => $loja_id,
                              'tipo_anuncio_id' => '1',
                              'turno' => $turno,
                              'device' => 'Mobile',
                              'place' => $place,
                              'position' => $position,
                              'imagem' => $imagem,
                              'arquivo' => $name,
                              'target' => $target,
                              'type' => $type,
                              'titulo' => $titulo,
                              'produto' => $produto,
                              'detalhe' => '',
                              'call_action' => $callEction,
                              'preco' => $preco,
                              'price_from' => $price_from,
                              'price_install' => $price_install,
                              'url' => $urlTipo,
                              'detalhe_tipo_anuncio' => '',
                              'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s')
                          ]);
                      $position ++;
                  endforeach;
              endforeach;


              //Brasil_Casasbahia_Mobile_Homepage_Organic
              $requestMobileHomeOrganic = $client->request('GET', 'https://data.import.io/extractor/9f9fad15-7a57-4abb-a72a-2f5b932d9c46/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
                  [
                      'headers' => [
                          'Accept' => 'application/json',
                          'Content-type'=> 'application/json',
                          'Accept-Encoding' => 'gzip'
                      ]
                  ]);

              $requestMobileHomeOrganic =  json_decode($requestMobileHomeOrganic->getBody(), true);
              $daddosHomeOrganic = $requestMobileHomeOrganic['result']['extractorData']["data"];
              $position = 1;
              $urlTipo = $requestMobileHomeOrganic['url'];

              foreach ( $daddosHomeOrganic as $dado):

                  foreach ($dado["group"]  as $value):

                      if (isset($value["Image"][0]["src"])) {

                          $imagem = $value["Image"][0]["src"];
                          $image = @file_get_contents($imagem);
                          $image = base64_encode($image);
                          $image = base64_decode($image);
                          $name = "Brasil_".$lojaNome."_Mobile_Homepage_Organic_".$data.$turno.$position.".jpg";
                          $im = @imagecreatefromstring($image);
                          header("Content-type: image/jpg");
                          @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                      } else {
                          $imagem = "";
                      }

                      if (isset($value["Target URL"][0]["text"])){
                          $target = $value["Target URL"][0]["text"];
                      } else {
                          $target = "";
                      }

                      if (isset($value["Place"][0]["text"])){
                          $place = $value["Place"][0]["text"];
                      } else {
                          $place = "";
                      }

                      if (isset($value["Title"][0]["text"])) {
                          $titulo = $value["Title"][0]["text"];

                      } else {
                          $titulo = "";
                      }

                      if (isset($value["Call to Action"][0]["text"])){
                          $callEction = $value["Call to Action"][0]["text"];
                      } else {
                          $callEction = "";
                      }

                      if (isset($value["Price"][0]["text"])){
                          $preco = $value["Price"][0]["text"];
                      } else {
                          $preco = "";
                      }

                      if(isset($value["Price From"][0]["text"])) {
                          $price_from= @$value["Price From"][0]["text"];
                      } else {
                          $price_from= "";
                      }

                      if(isset($value["Price Install"][0]["text"])) {
                          $price_install = $value["Price Install"][0]["text"];
                      } else {
                          $price_install = "";
                      }

                      if(isset($value["Product"][0]["text"])) {
                          $produto = $value["Product"][0]["text"];
                      } else {
                          $produto = "";
                      }

                      if(isset($value["Type"][0]["text"])) {
                          $type = $value["Type"][0]["text"];
                      } else {
                          $type = "";
                      }

                      $string = $titulo.$produto.$target. $urlTipo;

                      foreach ($marcas as $marca) {
                          $buscaMarca = strstr($string, $marca->descricao);
                          if($buscaMarca){
                              $marca_id = $marca->id;
                          }
                      }

                      DB::table('scraps')->insertGetId(
                          [
                              'pais_id' => $pais_id,
                              'tipo_pagina_id' => 1,
                              'categoria_id' => 7,
                              'marca_id' => $marca_id,
                              'loja_id' => $loja_id,
                              'tipo_anuncio_id' => '1',
                              'turno' => $turno,
                              'device' => 'Mobile',
                              'place' => $place,
                              'position' => $position,
                              'imagem' => $imagem,
                              'arquivo' => $name,
                              'target' => $target,
                              'type' => $type,
                              'titulo' => $titulo,
                              'produto' => $produto,
                              'detalhe' => '',
                              'call_action' => $callEction,
                              'preco' => $preco,
                              'price_from' => $price_from,
                              'price_install' => $price_install,
                              'url' => $urlTipo,
                              'detalhe_tipo_anuncio' => '',
                              'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s')
                          ]);
                      $position ++;
                  endforeach;
              endforeach;

    }
}
