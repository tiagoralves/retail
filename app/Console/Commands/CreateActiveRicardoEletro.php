<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Urlbox\Screenshots\Facades\Urlbox;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use App\Marca;

class CreateActiveRicardoEletro extends Command
{
    protected $signature = 'CreateActiveRicardoEletro:insert';
    protected $description = 'Create Screenshots DB';



    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $marcas = Marca::all();
        $marca_id = 0;

        $urlbox = \Urlbox\Screenshots\Urlbox::fromCredentials('API_KEY', 'API_SECRET');
        $client = new Client();

        $data = date('Y_m_d H:i:s');
        $dt = explode('_', $data);
        $mes = (int) $dt[1];
        $dh = explode(" ", $dt[2]);
        $dia = (int) $dh[0];
        $data = $dt[0]."_". $mes ."_". $dia;

        $horaG1 = strtotime('08:00');
        $horaG2 = strtotime('16:00');
        $horaG3 = strtotime('23:00');
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

        $lojadb = DB::table('lojas')->where('descricao', 'Ricardo Eletro')->first();
        $loja_id = $lojadb->id;
        $pais_id = $lojadb->pais_id;
        $lojaNome = "RicardoEletro";

        //BRASIL
   /*     $urlsDesktop = [
            //Ricardoeletro
            'ricardoeletro.com.br',
            'ricardoeletro.com.br/Loja/Celulares-e-Telefones/Smartphones/44-491',
            'ricardoeletro.com.br/Loja/TV-e-Video/TV/108-4370',
            'ricardoeletro.com.br/Loja/Eletrodomesticos/Refrigerador/256-270',
            'ricardoeletro.com.br/Loja/Eletrodomesticos/Lava-e-Seca/256-706',
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
                $im = @imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                @imagejpeg($im, "/var/www/html/retail/public/screenshots/brasil/desktop/".$dt[0]."/".$dt[1]."/".$name);

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
            //ricardoeletro
            'm.ricardoeletro.com.br',
            'm.ricardoeletro.com.br/Loja/Celulares-e-Telefones/Smartphones/44-491',
            'm.ricardoeletro.com.br/Loja/TV-e-Video/TV/108-4370',
            'm.ricardoeletro.com.br/Loja/Eletrodomesticos/Refrigerador/256-270',
            'm.ricardoeletro.com.br/Loja/Eletrodomesticos/Lava-e-Seca/256-706',
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
            $image = @file_get_contents($url);
            if ($image !== false) {

                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Brasil_".$loja."_Mobile_".$tipo.$data.$turno.".jpg";
                $im = @imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                @imagejpeg($im, "/var/www/html/retail/public/screenshots/brasil/mobile/".$dt[0]."/".$dt[1]."/".$name);

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


        //Brasil_Ricardo_Desktop_Category_Organic_Geladeira_
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/d2ecbd98-9783-43f2-ae4f-6add9a43dcbe?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fm.ricardoeletro.com.br%2FLoja%2FEletrodomesticos%2FRefrigerador%2F256-270',
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
                    $name = "Brasil_".$lojaNome."_Desktop_Category_Organic_Geladeira_".$data.$turno.$position.".jpg";
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

                $string = $titulo.$produto.$target.$urlTipo;

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
                        'url' => 2,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        

        //Brasil_Ricardo_Desktop_Category_Organic_Celular_
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/d2ecbd98-9783-43f2-ae4f-6add9a43dcbe?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fm.ricardoeletro.com.br%2FLoja%2FCelulares-e-Telefones%2FSmartphones%2F44-491',
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
                    $name = "Brasil_".$lojaNome."_Desktop_Category_Organic_Celular_".$data.$turno.$position.".jpg";
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

                $string = $titulo.$produto.$target.$urlTipo;

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
                        'url' => 44,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;

        //Brasil_MagazineLuiza_Desktop_Category_Organic_Tv_
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/d2ecbd98-9783-43f2-ae4f-6add9a43dcbe?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fm.ricardoeletro.com.br%2FLoja%2FTV-e-Video%2FTV%2F108-4370',
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
                    $name = "Brasil_".$lojaNome."_Desktop_Category_Organic_Tv_".$data.$turno.$position.".jpg";
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
                        'url' => 84,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;



        //Brasil_MagazineLuiza_Desktop_Category_Organic_Maquina_Lavar_
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/d2ecbd98-9783-43f2-ae4f-6add9a43dcbe?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fm.ricardoeletro.com.br%2FLoja%2FEletrodomesticos%2FLava-e-Seca%2F256-706',
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
                    $name = "Brasil_".$lojaNome."_Desktop_Category_Organic_Maquina_Lavar_".$data.$turno.$position.".jpg";
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

                $string = $titulo.$produto.$target.$urlTipo;

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
                        'url' => 129,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Brasil_Ricardo_Mobile_Category_Organic_Geladeira_
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/1187a801-229b-4546-b2d0-dc5e3eeba233?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fm.ricardoeletro.com.br%2FLoja%2FEletrodomesticos%2FRefrigerador%2F256-270',
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
                    $name = "Brasil_".$lojaNome."_Mobile_Category_Organic_Geladeira_".$data.$turno.$position.".jpg";
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

                $string = $titulo.$produto.$target.$urlTipo;

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
                        'url' => 207,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Brasil_MagazineLuiza_Mobile_Category_Organic_Celular_
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/1187a801-229b-4546-b2d0-dc5e3eeba233?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fm.ricardoeletro.com.br%2FLoja%2FCelulares-e-Telefones%2FSmartphones%2F44-491',
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
                    $name = "Brasil_".$lojaNome."_Mobile_Category_Organic_Celular_".$data.$turno.$position.".jpg";
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

                $string = $titulo.$produto.$target.$urlTipo;

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
                        'url' => 208,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Brasil_MagazineLuiza_Mobile_Category_Organic_Tv_
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/1187a801-229b-4546-b2d0-dc5e3eeba233?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fm.ricardoeletro.com.br%2FLoja%2FTV-e-Video%2FTV%2F108-4370',
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
                    $name = "Brasil_".$lojaNome."_Mobile_Category_Organic_Tv_".$data.$turno.$position.".jpg";
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

                $string = $titulo.$produto.$target.$urlTipo;

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
                        'url' => 209,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;

        //Brasil_MagazineLuiza_Mobile_Category_Organic_Maquina_Lavar_
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/1187a801-229b-4546-b2d0-dc5e3eeba233?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fm.ricardoeletro.com.br%2FLoja%2FEletrodomesticos%2FLava-e-Seca%2F256-706',
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
                    $name = "Brasil_".$lojaNome."_Mobile_Category_Organic_Maquina_Lavar_".$data.$turno.$position.".jpg";
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

                $string = $titulo.$produto.$target.$urlTipo;

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
                        'url' => 210,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;

        //Brasil_RicardoEletro_Desktop_Homepage_Ads
        $request = $client->request('GET', 'https://data.import.io/extractor/fff5d33e-7973-4da6-815c-a0aec5dfa29e/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
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
                    $name = "Brasil_".$lojaNome."_Desktop_Homepage_Ads_".$data.$turno.$position.".jpg";
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

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
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

        //Brasil_RicardoEletro_Mobile_Homepage_Organic
        $request = $client->request('GET', 'https://data.import.io/extractor/fd42f2b9-d536-4f16-b3cc-c4d40aaf7984/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
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

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
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


        //Brasil_RicardoEletro_Desktop_Homepage_Organic
        $request = $client->request('GET', 'https://data.import.io/extractor/e6f0b379-2f09-465b-ab79-36b5c9eceffb/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
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

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }
                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 1,
                        'categoria_id' => 7,
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

        //Brasil_RicardoEletro_Mobile_Homepage_Carousel
       $request = $client->request('GET', 'https://data.import.io/extractor/1c98029c-bc70-433b-81b7-a1ceb4ffb5a4/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
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
                    $name = "Brasil_".$lojaNome."_Mobile_Homepage_Carousel_".$data.$turno.$position.".jpg";
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

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }
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

        //Brasil_RicardoEletro_Desktop_Homepage_Carousel
        $request = $client->request('GET', 'https://data.import.io/extractor/aea4c09c-2ded-4f96-8038-052469c15d81/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
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
                    $name = "Brasil_".$lojaNome."_Desktop_Homepage_Carousel_".$data.$turno.$position.".jpg";
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
    }
}
