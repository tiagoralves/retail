<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Urlbox\Screenshots\Facades\Urlbox;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class CreateActivePanafoto extends Command
{

    protected $signature = 'CreateActivePanafoto:insert';
    protected $description = 'Create Screenshots DB';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
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
        if(!is_dir("/var/www/html/retail/public/screenshots/sela/desktop/".$dt[0])) {
            mkdir("/var/www/html/retail/public/screenshots/sela/desktop/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/screenshots/sela/desktop/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/screenshots/sela/desktop/".$dt[0]."/".$dt[1], 0777);
        }
        //criacao de desktop mobile
        if(!is_dir("/var/www/html/retail/public/screenshots/sela/mobile/".$dt[0])) {
            mkdir("/var/www/html/retail/public/screenshots/sela/mobile/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/screenshots/sela/mobile/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/screenshots/sela/mobile/".$dt[0]."/".$dt[1], 0777);
        }

        $lojadb = DB::table('lojas')->where('descricao', 'Panafoto')->first();
        $loja_id = $lojadb->id;
        $pais_id = $lojadb->pais_id;
        $lojaNome = 'Panafoto';



        $urlDesktopSela = [
            'panafoto.com',
            'panafoto.com/categorias/productos/es/celulares_android/50',
            'panafoto.com/categorias/productos/es/tv_uhd_4k/307',
            'panafoto.com/categorias/productos/es/refrigeradoras/39',
            'panafoto.com/categorias/productos/es/lavadoras/34'
        ];

        $contDesktopSela = 0;
        //      $options["proxy"] = 'sonar:sonar@2017@panama.wonderproxy.com:10000';

        foreach ( $urlDesktopSela as $value):

            if( $contDesktopSela==0 ) {
                $tipo = 'Homepage_';
            } elseif( $contDesktopSela == 1 ) {
                $tipo = 'Smartphones_';
            }elseif( $contDesktopSela == 2 ) {
                $tipo = 'TVs_';
            }elseif( $contDesktopSela == 3 ) {
                $tipo = 'Refrigerators_';
            }elseif ( $contDesktopSela == 4) {
                $tipo = 'Washing Machines_';
            }

            $options["url"] = $value;
            $options["format"] = "jpg";
            $options["quality"] = 70;
            $options["full_page"] = true;
            $urlboxUrl = Urlbox::generateUrl($options);

            $url = $urlboxUrl;
            $image = @file_get_contents($url);
            if ($image !== false) {

                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Sela_".$lojaNome."_Desktop_".$tipo.$data.$turno.".jpg";
                $im = @imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                imagejpeg($im, "/var/www/html/retail/public/screenshots/sela/desktop/".$dt[0]."/".$dt[1]."/".$name);

                DB::table('screenshots')->insert(
                    [
                        'pais_id' => $pais_id,
                        'link' => $urlboxUrl,
                        'arquivo'=> $name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );

            } else {
                echo 'Ocorreu um erro.';

            }
            $contDesktopSela ++;
        endforeach;

        $urlMobileSela = [
            'panafoto.com',
            'panafoto.com/categorias/productos/es/celulares_android/50',
            'panafoto.com/categorias/productos/es/tv_uhd_4k/307',
            'panafoto.com/categorias/productos/es/refrigeradoras/39',
            'panafoto.com/categorias/productos/es/lavadoras/34',
        ];

        $contMobileSela = 0;

        foreach ( $urlMobileSela as $value):

            $grupo = explode(".", $value);
            $loja = $grupo[0];
            $loja = ucfirst($loja);

            if( $contMobileSela==0 ) {
                $tipo = 'Homepage_';
            } elseif( $contMobileSela == 1 ) {
                $tipo = 'Smartphones_';
            }elseif( $contMobileSela == 2 ) {
                $tipo = 'TVs_';
            }elseif( $contMobileSela == 3 ) {
                $tipo = 'Refrigerators_';
            }elseif ( $contMobileSela == 4) {
                $tipo = 'Washing Machines_';
            }

            $options["url"] = $value;
            $options["format"] = "jpg";
            $options["quality"] = 70;
            $options["full_page"] = true;
            $urlboxUrl = Urlbox::generateUrl($options);

            $url = $urlboxUrl;
            $image = @file_get_contents($url);
            if ($image !== false) {

                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Sela_".$lojaNome."_Mobile_".$tipo.$data.$turno.".jpg";
                $im = @imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                imagejpeg($im, "/var/www/html/retail/public/screenshots/sela/mobile/".$dt[0]."/".$dt[1]."/".$name);

                DB::table('screenshots')->insert(
                    [
                        'pais_id' => $pais_id,
                        'link' => $urlboxUrl,
                        'arquivo'=> $name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );

            } else {
                echo 'Ocorreu um erro.';

            }
            $contMobileSela ++;
        endforeach;


        //import.io
        //criacao de diretorio desktop
        if(!is_dir("/var/www/html/retail/public/printshtml/sela/desktop/".$dt[0])) {
            mkdir("/var/www/html/retail/public/printshtml/sela/desktop/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/printshtml/sela/desktop/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/printshtml/sela/desktop/".$dt[0]."/".$dt[1], 0777);
        }
        //criacao de desktop mobile
        if(!is_dir("/var/www/html/retail/public/printshtml/sela/mobile/".$dt[0])) {
            mkdir("/var/www/html/retail/public/printshtml/sela/mobile/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/printshtml/sela/mobile/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/printshtml/sela/mobile/".$dt[0]."/".$dt[1], 0777);
        }

        //SELA_Panafoto_Desktop_Category_Organic
        $requestDeskeCategoryOrganic = $client->request('GET', 'https://extraction.import.io/query/extractor/5085b4f5-d3cf-4c0d-991f-08b581b3e9ac?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.garbarino.com%2F',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestDeskeCategoryOrganic =  json_decode($requestDeskeCategoryOrganic->getBody(), true);

        $dadosDeskeCategoryOrganic = $requestDeskeCategoryOrganic['extractorData']["data"];
        $position = 1;

        $urlTipo = $requestDeskeCategoryOrganic['url'];
        $timestamp = $requestDeskeCategoryOrganic["timestamp"];
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        $date_captura = date_format($date, 'U = Y-m-d H:i:s');

        foreach ( $dadosDeskeCategoryOrganic as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $im = @imagecreatefromwebp($value["Image"][0]["src"]);
                    $name = "Sela_".$lojaNome."_Desktop_Category_Organic_".$data.$turno.$position.".jpg";
                    header('Content-Type: image/jpg');
                    imagejpeg($im, '/var/www/html/retail/public/printshtml/sela/desktop/'.$dt[0]."/".$dt[1]."/".$name, 100);
                    $name = $value["Image"][0]["src"];
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
                    $price_from = @$value["Price From"][0]["text"];
                } else {
                    $price_from = "";
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

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => '1',
                        'categoria_id' => '1',
                        'marca_id' => '1',
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

        //SELA_Panafoto_Desktop_Homepage_Ads
        $requestDeskeHomeAds = $client->request('GET', 'https://data.import.io/extractor/53c5d3fe-0ed9-4983-98a3-fae64a289365/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestDeskeHomeAds =  json_decode($requestDeskeHomeAds->getBody(), true);

        $dadosDeskeHomeAds = $requestDeskeHomeAds['result']['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestDeskeHomeAds['url'];


        foreach ( $dadosDeskeHomeAds as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Sela_".$lojaNome."_Desktop_Homepage_Ads_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/sela/desktop/".$dt[0]."/".$dt[1]."/".$name);

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
                    $price_from = @$value["Price From"][0]["text"];
                } else {
                    $price_from = "";
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

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => '1',
                        'categoria_id' => '1',
                        'marca_id' => '1',
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


        //SELA_Panafoto_Desktop_Homepage_Organic
        $requestDeskHomeOrganic = $client->request('GET', 'https://data.import.io/extractor/ef1f8ac4-307e-4ae1-82d0-52dc0c23aa47/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestDeskHomeOrganic =  json_decode($requestDeskHomeOrganic->getBody(), true);

        $dadosDeskHomeOrganic = $requestDeskHomeOrganic['result']['extractorData']["data"];
        $position = 1;

        $urlTipo = $requestDeskHomeOrganic['url'];

        foreach ( $dadosDeskHomeOrganic as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Sela_".$lojaNome."_Desktop_Homepage_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/sela/desktop/".$dt[0]."/".$dt[1]."/".$name);
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
                    $price_from = @$value["Price From"][0]["text"];
                } else {
                    $price_from = "";
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

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => '1',
                        'categoria_id' => '1',
                        'marca_id' => '1',
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

        //********************************MOBILE*************************************************
        //SELA_Panafoto_Mobile_Category_Organic
        $requestDeskeCategoryOrganic = $client->request('GET', 'https://extraction.import.io/query/extractor/5085b4f5-d3cf-4c0d-991f-08b581b3e9ac?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.garbarino.com%2F',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestDeskeCategoryOrganic =  json_decode($requestDeskeCategoryOrganic->getBody(), true);

        $dadosDeskeCategoryOrganic = $requestDeskeCategoryOrganic['extractorData']["data"];
        $position = 1;

        $urlTipo = $requestDeskeCategoryOrganic['url'];
        $timestamp = $requestDeskeCategoryOrganic["timestamp"];
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        $date_captura = date_format($date, 'U = Y-m-d H:i:s');

        foreach ( $dadosDeskeCategoryOrganic as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $im = @imagecreatefromwebp($value["Image"][0]["src"]);
                    $name = "Sela_".$lojaNome."_Mobile_Category_Organic_".$data.$turno.$position.".jpg";
                    header('Content-Type: image/jpg');
                    imagejpeg($im, '/var/www/html/retail/public/printshtml/sela/mobile/'.$dt[0]."/".$dt[1]."/".$name, 100);
                    $name = $value["Image"][0]["src"];
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
                    $price_from = @$value["Price From"][0]["text"];
                } else {
                    $price_from = "";
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

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => '1',
                        'categoria_id' => '1',
                        'marca_id' => '1',
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

        //SELA_Panafoto_Mobile_Homepage_Ads
        $requestDeskeHomeAds = $client->request('GET', 'https://data.import.io/extractor/53c5d3fe-0ed9-4983-98a3-fae64a289365/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestDeskeHomeAds =  json_decode($requestDeskeHomeAds->getBody(), true);

        $dadosDeskeHomeAds = $requestDeskeHomeAds['result']['extractorData']["data"];
        $position = 1;

        $urlTipo = $requestDeskeHomeAds['url'];

        foreach ( $dadosDeskeHomeAds as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];

                    $imagem = $value["Image"][0]["src"];
                    $extensao =  substr($imagem, -3);
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    if( $extensao = "jpg") {
                        $name = "Sela_".$lojaNome."_Mobile_Homepage_Ads_".$data.$turno.$position.".jpg";
                        $im = @imagecreatefromstring($image);
                        header("Content-type: image/jpg");
                        @imagejpeg($im, "/var/www/html/retail/public/printshtml/sela/mobile/".$dt[0]."/".$dt[1]."/".$name);
                    } elseif( $extensao = "gif") {
                        $name = "Sela_".$lojaNome."_Mobile_Homepage_Ads_".$data.$turno.$position.".gif";
                        $im = @imagecreatefromstring($image);
                        header("Content-type: image/gif");
                        @imagegif($im, "/var/www/html/retail/public/printshtml/sela/mobile/".$dt[0]."/".$dt[1]."/".$name);

                    } elseif( $extensao = "png") {
                        $name = "Sela_".$lojaNome."_Mobile_Homepage_Ads_".$data.$turno.$position.".png";
                        $im = @imagecreatefromstring($image);
                        header("Content-type: image/png");
                        @imagegif($im, "/var/www/html/retail/public/printshtml/sela/mobile/".$dt[0]."/".$dt[1]."/".$name);

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
                    $price_from = @$value["Price From"][0]["text"];
                } else {
                    $price_from = "";
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

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => '1',
                        'categoria_id' => '1',
                        'marca_id' => '1',
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


        //SELA_Panafoto_Sela_Homepage_Organic
        $requestDeskHomeOrganic = $client->request('GET', 'https://data.import.io/extractor/ef1f8ac4-307e-4ae1-82d0-52dc0c23aa47/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestDeskHomeOrganic =  json_decode($requestDeskHomeOrganic->getBody(), true);

        $dadosDeskHomeOrganic = $requestDeskHomeOrganic['result']['extractorData']["data"];
        $position = 1;

        $urlTipo = $requestDeskHomeOrganic['url'];

        foreach ( $dadosDeskHomeOrganic as $dado):

            foreach ($dado["group"]  as $value):
                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Sela_".$lojaNome."_Mobile_Homepage_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/sela/mobile/".$dt[0]."/".$dt[1]."/".$name);
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
                    $price_from = @$value["Price From"][0]["text"];
                } else {
                    $price_from = "";
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

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => '1',
                        'categoria_id' => '1',
                        'marca_id' => '1',
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
