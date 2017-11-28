<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Urlbox\Screenshots\Facades\Urlbox;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class CreateActiveRibeiro extends Command
{

    protected $signature = 'CreateActiveRibeiro:insert';
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
        if(!is_dir("/var/www/html/retail/public/screenshots/argentina/desktop/".$dt[0])) {
            mkdir("/var/www/html/retail/public/screenshots/argentina/desktop/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/screenshots/argentina/desktop/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/screenshots/argentina/desktop/".$dt[0]."/".$dt[1], 0777);
        }
        //criacao de desktop mobile
        if(!is_dir("/var/www/html/retail/public/screenshots/argentina/mobile/".$dt[0])) {
            mkdir("/var/www/html/retail/public/screenshots/argentina/mobile/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/screenshots/argentina/mobile/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/screenshots/argentina/mobile/".$dt[0]."/".$dt[1], 0777);
        }

        $lojadb = DB::table('lojas')->where('descricao', 'Ribeiro')->first();
        $loja_id = $lojadb->id;
        $pais_id = $lojadb->pais_id;
        $lojaNome = "Ribeiro";

        //Argentina
        $urlArgentinaDesktop = [
            'ribeiro.com.ar',
            'ribeiro.com.ar/browse/celulares-celulares-libres/_/N-1vpfmld',
            'ribeiro.com.ar/browse/televisores-audio-foto-y-video-televisores-smart-tv-led/_/N-13nn749',
            'ribeiro.com.ar/browse/Heladeras-Cocina-y-Lavado-Heladeras-Con-Freezer-No-frost/_/N-1kfjx94',
            'https://www.ribeiro.com.ar/browse/heladeras-cocina-y-lavado-lavado/_/N-1korz5r'
        ];


        $contArgentina = 0;
        //       $options["proxy"] = 'sonar:sonar@2017@buenosaires.wonderproxy.com:10000';

        foreach ( $urlArgentinaDesktop as $value):

            if( $contArgentina==0 ) {
                $tipo = 'Homepage_';
            } elseif( $contArgentina == 1 ) {
                $tipo = 'Smartphones_';
            }elseif( $contArgentina == 2 ) {
                $tipo = 'TVs_';
            }elseif( $contArgentina == 3 ) {
                $tipo = 'Refrigerators_';
            }elseif ( $contArgentina == 4) {
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
                $name = "Argentina_".$lojaNome."_Desktop_".$tipo.$data.$turno.".jpg";
                $im = imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                imagejpeg($im, "/var/www/html/retail/public/screenshots/argentina/desktop/".$dt[0]."/".$dt[1]."/".$name);

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
            $contArgentina ++;
        endforeach;

        $urlArgentinaMobile = [
            'ribeiro.com.ar/mobile/mobile',
            'ribeiro.com.ar/mobile/mobile/browse/celulares-celulares-libres/_/N-1vpfmld',
            'ribeiro.com.ar/mobile/mobile/browse/televisores-audio-foto-y-video-televisores-smart-tv-led/_/N-13nn749',
            'ribeiro.com.ar/mobile/mobile/browse/heladeras-cocina-y-lavado-heladeras-con-freezer-no-frost/_/N-1kfjx94',
            'ribeiro.com.ar/mobile/mobile/browse/heladeras-cocina-y-lavado-lavado-lavarropas-automatico/_/N-vlbaf6'
        ];

        $contMobileArgentina = 0;

        foreach ( $urlArgentinaMobile as $value):

            if( $contMobileArgentina==0 ) {
                $tipo = 'Homepage_';
            } elseif( $contMobileArgentina == 1 ) {
                $tipo = 'Smartphones_';
            }elseif( $contMobileArgentina == 2 ) {
                $tipo = 'TVs_';
            }elseif( $contMobileArgentina == 3 ) {
                $tipo = 'Refrigerators_';
            }elseif ( $contMobileArgentina == 4) {
                $tipo = 'Washing Machines_';
            }

            $options["url"] = $value;
            $options["format"] = "jpg";
            $options["user_agent"] = 'mobile';
            $options["quality"] = 70;
            $options["full_page"] = true;
            $options["force"] = true;

            $urlboxUrl = Urlbox::generateUrl($options);

            $url = $urlboxUrl;
            $image = @file_get_contents($url);
            if ($image !== false) {

                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Argentina_".$lojaNome."_Mobile_".$tipo.$data.$turno.".jpg";
                $im = imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                imagejpeg($im, "/var/www/html/retail/public/screenshots/argentina/mobile/".$dt[0]."/".$dt[1]."/".$name);

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
            $contMobileArgentina ++;
        endforeach;


        //import.io
        //criação diretório desktop
        if(!is_dir("/var/www/html/retail/public/printshtml/argentina/desktop/".$dt[0])) {
            mkdir("/var/www/html/retail/public/printshtml/argentina/desktop/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/printshtml/argentina/desktop/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/printshtml/argentina/desktop/".$dt[0]."/".$dt[1], 0777);
        }
        //criacao diretório mobile
        if(!is_dir("/var/www/html/retail/public/printshtml/argentina/mobile/".$dt[0])) {
            mkdir("/var/www/html/retail/public/printshtml/argentina/mobile/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/printshtml/argentina/mobile/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/printshtml/argentina/mobile/".$dt[0]."/".$dt[1], 0777);
        }


        //Argentina_Ribeiro_Mobile_Category_Organic
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/975ea88c-2eb3-46a4-b274-49d944cb9fde?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.ribeiro.com.ar%2Fbrowse%2Fcelulares-celulares-libres%2F_%2FN-1vpfmld',
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

                if (isset($value["Image"][0]["text"])) {

                    $imagem = $value["Image"][0]["text"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Argentina_".$lojaNome."_Mobile_Category_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/argentina/mobile/".$dt[0]."/".$dt[1]."/".$name);

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


        //Argentina_Ribeiro_Desktop_Category_Organic
       $request = $client->request('GET', 'https://extraction.import.io/query/extractor/0a139b0f-0d8b-4f1a-9dcb-2567fc33b4d6?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.ribeiro.com.ar%2Fbrowse%2Fcelulares-celulares-libres%2F_%2FN-1vpfmld',
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
                    $name = "Argentina_".$lojaNome."_Desktop_Category_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/argentina/desktop/".$dt[0]."/".$dt[1]."/".$name);

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


        //Argentina_Ribeiro_Mobile_Homepage_Ads
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/d32e1f13-95d3-4099-b8f7-851e0dd29f36?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.ribeiro.com.ar%2Fmobile%2Fmobile%2F',
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
                    $name = "Argentina_".$lojaNome."_Mobile_Homepage_Ads_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/argentina/mobile/".$dt[0]."/".$dt[1]."/".$name);

                } else {
                    $imagem = "";
                    $name = ""; //0800 -702-3535
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


        //Argentina_Ribeiro_Desktop_Homepage_Ads
       $request = $client->request('GET', 'https://extraction.import.io/query/extractor/b9dff944-2d72-4893-8460-673dc986e9b4?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.ribeiro.com.ar%2F',
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
                    $name = "Argentina_".$lojaNome."_Desktop_Homepage_Ads_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/argentina/desktop/".$dt[0]."/".$dt[1]."/".$name);

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

        //Argentina_Ribeiro_Mobile_Homepage_Organic
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/a2e34e01-936d-49ca-b775-d0f9738bb9e4?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.ribeiro.com.ar%2F',
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
                    $name = "Argentina_".$lojaNome."_Mobile_Homepage_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/argentina/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

        //Argentina_Ribeiro_Desktop_Homepage_Organic
        $request = $client->request('GET', 'https://data.import.io/extractor/1d68a134-8182-4c1c-859f-4c1495ced9e8/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
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

                if (isset($value["Image"][0]["text"])) {

                    $imagem = $value["Image"][0]["text"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Argentina_".$lojaNome."_Desktop_Homepage_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/argentina/desktop/".$dt[0]."/".$dt[1]."/".$name);

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

        //Argentina_Ribeiro_Mobile_Homepage_Carousel
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/2b7d3d87-3e8a-4f33-9839-1d6881e8b4c9?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.ribeiro.com.ar%2F',
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
                    $image = file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Argentina_".$lojaNome."_Mobile_Homepage_Carousel_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/argentina/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

        //Argentina_Ribeiro_Desktop_Homepage_Carousel
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/cb5d8f3c-c781-4231-9caf-d343cb6269cc?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.ribeiro.com.ar%2F',
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
                    $name = "Argentina_".$lojaNome."_Desktop_Homepage_Carousels_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/argentina/desktop/".$dt[0]."/".$dt[1]."/".$name);

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
