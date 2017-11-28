<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Urlbox\Screenshots\Facades\Urlbox;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class CreateActiveWalmartBrasil extends Command
{

    protected $signature = 'CreateActiveWalmartBrasil:insert';
    protected $description = 'Create Screenshots DB';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $urlbox = \Urlbox\Screenshots\Urlbox::fromCredentials('API_KEY', 'API_SECRET');
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

        $lojadb = DB::table('lojas')->where('descricao', 'Walmart')->first();
        $loja_id = $lojadb->id;
        $pais_id = $lojadb->pais_id;
        $lojaNome = "Walmart";

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

        $urlsDesktop = [
            //Walmart
            'walmart.com.br',
            'walmart.com.br/categoria/telefonia/smartphones/?fq=C:4833/4835/4845/&PS=20',
            'walmart.com.br/categoria/eletronicos/tvs/?fq=C:7240/7242/&PS=20&mm=100',
            'walmart.com.br/categoria/eletrodomesticos/refrigeracao/?fq=C:144/7952/&PS=20',
            'walmart.com.br/categoria/eletrodomesticos/lavanderia/?fq=C:144/7953',
        ];

        $cont = 0;

        foreach ( $urlsDesktop as $value):

            $grupo = explode(".", $value);
            $loja = $grupo[0];
            $loja = ucfirst($loja);

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
            $urlboxUrl = Urlbox::generateUrl($options);

            $url = $urlboxUrl;
            $image = @file_get_contents($url);
            if ($image !== false) {

                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Brasil_".$loja."_Desktop_".$tipo.$data.$turno.".jpg";
                $im = imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                imagejpeg($im, "/var/www/html/retail/public/screenshots/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

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
            $cont ++;
        endforeach;


        $urlMobile = [
            //Walmart
            'walmart.com.br',
            'walmart.com.br/categoria/telefonia/smartphones/?fq=C:4833/4835/4845/&PS=20',
            'walmart.com.br/categoria/eletronicos/tvs/?fq=C:7240/7242/&PS=20&mm=100',
            'walmart.com.br/categoria/eletrodomesticos/refrigeracao/?fq=C:144/7952/&PS=20',
            'walmart.com.br/categoria/eletrodomesticos/lavanderia/?fq=C:144/7953',
        ];
        $contMobile = 0;

        foreach ( $urlMobile as $value):

            $grupo = explode(".", $value);
            if ( $grupo[0] == 'm') {
                $loja = $grupo[1];
            } else {
                $loja = $grupo[0];
            }
            $loja = ucfirst($loja);
            $data = date('Y_m_d');

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
                $name = "Brasil_".$loja."_Mobile_".$tipo.$data.$turno.".jpg";
                $im = @imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                imagejpeg($im, "/var/www/html/retail/public/screenshots/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

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
            $contMobile ++;
        endforeach;
        
        //Import. io
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




        //Brasil_Walmart_Desktop_Homepage_Carousel
        $request = $client->request('GET', 'http://data.import.io/extractor/42218a41-41ef-4de8-b483-ddf3b6e7b6ac/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);
        

        $request =  json_decode($request->getBody(), true);
        $dadosRequest = $request['result']['extractorData']["data"];
        $position = 1;
        $urlTipo = $request['url'];

        foreach ( $dadosRequest as $dado):
            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = file_get_contents($imagem);
                    $image= base64_encode($imagem);
                    $image = base64_decode($imagem);
                    $name = "Brasil_".$lojaNome."_Desktop_Homepage_Carousel_".$data.$turno.$position.".png";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/png");
                    imagepng($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                    $name = "";
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

        //Brasil_Walmart_Desktop_Category_Organic
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/387bf01f-4dc5-4776-b27b-0fd73c7d023f?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.walmart.com.br%2Fcategoria%2Ftelefonia%2Fsmartphones%2F%3Ffq%3DC%3A4833%2F4835%2F4845%2F%26PS%3D20',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);
        $request =  json_decode($request->getBody(), true);
        $dadosRequest = $request['extractorData']["data"];

        $position = 1;

        $urlTipo = $request['url'];

        foreach ( $dadosRequest as $dado):

            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Desktop_Category_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                    $name = "";
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

        //Brasil_Walmart_Mobile_Category_Organic
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/59e4d466-511e-4c02-8c7d-ad4c8f33ed65?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fm.walmart.com.br%2Fcategoria%2Ftelefonia%2Fsmartphones%2F%3Ffq%3DC%3A4833%2F4835%2F4845%2F%26PS%3D20',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $request =  json_decode($request->getBody(), true);
        $dadosRequest = $request['extractorData']["data"];
        $position = 1;
        $urlTipo = $request['url'];

        foreach ( $dadosRequest as $dado):

            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Mobile_Category_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                    $name = "";
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

        //Brasil_Walmart_Mobile_Homepage_Ads
        $request = $client->request('GET', 'https://data.import.io/extractor/a37c8d7d-40b2-44b5-bb4a-c9fd1e9dc7ab/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $request =  json_decode($request->getBody(), true);
        $dadosRequest = $request['result']['extractorData']["data"];
        $position = 1;

        $urlTipo = $request['url'];

        foreach ( $dadosRequest as $dado):

            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Mobile_Homepage_Ads_".$data.$turno.$position.".png";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/png");
                    @imagepng($im, "/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                    $name = "";
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


        //Brasil_Walmart_Desktop_Homepage_Ads
        $request = $client->request('GET', 'https://data.import.io/extractor/039b46f0-3741-4d37-9fe9-9a04be53f481/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $request =  json_decode($request->getBody(), true);
        $dadosRequest = $request['result']['extractorData']["data"];
        $position = 1;

        $urlTipo = $request['url'];

        foreach ( $dadosRequest as $dado):

            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Desktop_Homepage_Ads_".$data.$turno.$position.".png";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/png");
                    @imagepng($im, "/var/www/html/retail/public/printshtml/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                    $name = "";
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


        //Brasil_Walmart_Mobile_Homepage_Organic
        $request = $client->request('GET', 'https://data.import.io/extractor/28cdee29-8276-496b-8993-9cd08d9f5436/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $request =  json_decode($request->getBody(), true);
        $dadosRequest = $request['result']['extractorData']["data"];
        $position = 1;

        $urlTipo = $request['url'];

        foreach ( $dadosRequest as $dado):

            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Brasil_".$lojaNome."_Mobile_Homepage_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                    $name = "";
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


        //Brasil_Walmart_Desktop_Homepage_Organic
        $request = $client->request('GET', 'https://data.import.io/extractor/c0bafe88-ab05-424d-968d-b9e29ba262f6/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $request =  json_decode($request->getBody(), true);
        $dadosRequest = $request['result']['extractorData']["data"];
        $position = 1;

        $urlTipo = $request['url'];

        foreach ( $dadosRequest as $dado):

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
                    $name = "";
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
    }
}
