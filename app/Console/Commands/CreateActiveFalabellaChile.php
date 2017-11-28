<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Urlbox\Screenshots\Facades\Urlbox;
use DB;
use App\Marca;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class CreateActiveFalabellaChile extends Command
{

    protected $signature = 'CreateActiveFalabellaChile:insert';
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
        if(!is_dir("/var/www/html/retail/public/screenshots/chile/desktop/".$dt[0])) {
            mkdir("/var/www/html/retail/public/screenshots/chile/desktop/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/screenshots/chile/desktop/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/screenshots/chile/desktop/".$dt[0]."/".$dt[1], 0777);
        }
        //criacao de desktop mobile
        if(!is_dir("/var/www/html/retail/public/screenshots/chile/mobile/".$dt[0])) {
            mkdir("/var/www/html/retail/public/screenshots/chile/mobile/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/screenshots/chile/mobile/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/screenshots/chile/mobile/".$dt[0]."/".$dt[1], 0777);
        }

        //CHILE
        $lojadb = DB::table('lojas')->where('descricao', 'Falabella - Chile')->first();
        $loja_id = $lojadb->id;
        $pais_id = $lojadb->pais_id;
        $lojaNome = "Falabella";

        $urslDesktopChile = [

            //falabella
            'falabella.com/falabella-cl/',
            'falabella.com/falabella-cl/category/cat720161/Smartphones',
            'falabella.com/falabella-cl/category/cat1012/TV',
            'falabella.com/falabella-cl/category/cat3205/Refrigeradores',
            'falabella.com/falabella-cl/category/cat4060/Lavadoras'
        ];

                 $options["proxy"] = 'sonar:sonar@2017@santiago.wonderproxy.com:10000';

                 $contchileD = 0;

                 foreach ( $urslDesktopChile as $value):

                     $grupo = explode(".", $value);
                     if ( $grupo[0] == 'm') {
                         $loja = $grupo[1];
                     } else {
                         $loja = $grupo[0];
                     }
                     $loja = ucfirst($loja);
                     $data = date('Y_m_d');
                     $dt = explode('_', $data);
                     $mes = (int) $dt[1];
                     $dia = (int) $dt[2];
                     $data = $dt[0]."_". $mes ."_". $dia;

                     if( $contchileD==0 ) {
                         $tipo = 'Homepage_';
                     } elseif( $contchileD == 1 ) {
                         $tipo = 'Smartphones_';
                     } elseif( $contchileD == 2 ) {
                         $tipo = 'TVs_';
                    } elseif( $contchileD == 3 ) {
                        $tipo = 'Refrigerators_';
                    } elseif ( $contchileD == 4) {
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
                         $name = "Chile_".$loja."_Desktop_".$tipo.$data."G1".".jpg";
                         $im = imagecreatefromstring($image);
                         header('Content-Type: image/jpg');
                         imagejpeg($im, "/var/www/html/retail/public/screenshots/chile/desktop/".$dt[0]."/".$dt[1]."/".$name);

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
                         echo 'Ocorreu um erro em Chile Desktop:' . $tipo;

                     }
                     $contchileD ++;
                 endforeach;


                 $urslMobileChile = [
                     //falabella
                     'falabella.com/falabella-cl',
                     'falabella.com/falabella-cl/category/cat720161/Smartphones',
                     'falabella.com/falabella-cl/category/cat1012/TV',
                     'falabella.com/falabella-cl/category/cat3205/Refrigeradores',
                     'falabella.com/falabella-cl/category/cat4060/Lavadoras'
                 ];

                 $contchileM = 0;

                 foreach ( $urslMobileChile as $value):

                     $grupo = explode(".", $value);
                     $loja = $grupo[0];
                     $loja = ucfirst($loja);
                     $data = date('Y_m_d');

                     if( $contchileM==0 ) {
                         $tipo = 'Homepage_';
                     } elseif( $contchileM == 1 ) {
                         $tipo = 'Smartphones_';
                     }elseif( $contchileM == 2 ) {
                         $tipo = 'TVs_';
                     }elseif( $contchileM == 3 ) {
                         $tipo = 'Refrigerators_';
                     }elseif ( $contchileM == 4) {
                         $tipo = 'Washing Machines_';
                     }

                     $options["url"] = $value;
                     $options["format"] = "jpg";
                     $options["quality"] = 70;
                     $options["full_page"] = true;
                     $options["force"] = true;
                     $urlboxUrl = Urlbox::generateUrl($options);

                     $url = $urlboxUrl;
                     $image = file_get_contents($url);
                     if ($image !== false) {

                         $image= base64_encode($image);
                         $image = base64_decode($image);
                         $name = "Chile_".$loja."_Mobile_".$tipo.$data.$turno.".jpg";
                         $im = imagecreatefromstring($image);
                         header('Content-Type: image/jpg');
                         imagejpeg($im, "/var/www/html/retail/public/screenshots/chile/mobile/".$dt[0]."/".$dt[1]."/". $name);

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
                         imagedestroy($im);

                     } else {
                         echo 'Ocorreu um erro.';

                     }
                     $contchileM ++;
                 endforeach;

        //import.io
        //criação diretório desktop
        if(!is_dir("/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0])) {
            mkdir("/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0]."/".$dt[1], 0777);
        }
        //criacao diretório mobile
        if(!is_dir("/var/www/html/retail/public/printshtml/chile/mobile/".$dt[0])) {
            mkdir("/var/www/html/retail/public/printshtml/chile/mobile/".$dt[0], 0777);
        }

        if(!is_dir("/var/www/html/retail/public/printshtml/chile/mobile/".$dt[0]."/".$dt[1])){
            mkdir("/var/www/html/retail/public/printshtml/chile/mobile/".$dt[0]."/".$dt[1], 0777);
        }


        //Chile_Falabella_Desktop_Category_Organic Celular
        $requestFalabellaDeskCatOrg= $client->request('GET', 'https://extraction.import.io/query/extractor/22e814af-da58-46fb-a762-5c3bfe1f523f?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.falabella.com%2Ffalabella-cl%2Fcategory%2Fcat720161%2FSmartphones',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestFalabellaDeskCatOrg =  json_decode($requestFalabellaDeskCatOrg->getBody(), true);

        $dadosFalabellaDeskCatOrg = $requestFalabellaDeskCatOrg['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestFalabellaDeskCatOrg['url'];


        foreach ( $dadosFalabellaDeskCatOrg as $dado):


        foreach ($dado["group"]  as $value):

            if (isset($value["Image"][0]["src"])) {

                $imagem = $value["Image"][0]["src"];
                $image = @file_get_contents($imagem);
                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Chile_".$lojaNome."_Desktop_Category_Organic_Celular_".$data.$turno.$position.".jpg";
                $im = @imagecreatefromstring($image);
                header("Content-type: image/jpg");
                @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0]."/".$dt[1]."/".$name);

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
                    'tipo_pagina_id' => 4,
                    'categoria_id' => 1,
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
                    'url' => 54,
                    'detalhe_tipo_anuncio' => '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            $position ++;

        endforeach;
    endforeach;


        //Chile_Falabella_Mobile_Category_Organic Celular
        $requestFalabellaDeskCatOrg= $client->request('GET', 'https://extraction.import.io/query/extractor/22e814af-da58-46fb-a762-5c3bfe1f523f?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.falabella.com%2Ffalabella-cl%2Fcategory%2Fcat720161%2FSmartphones',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestFalabellaDeskCatOrg =  json_decode($requestFalabellaDeskCatOrg->getBody(), true);

        $dadosFalabellaDeskCatOrg = $requestFalabellaDeskCatOrg['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestFalabellaDeskCatOrg['url'];


        foreach ( $dadosFalabellaDeskCatOrg as $dado):


            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Chile_".$lojaNome."_Mobile_Category_Organic_Celular_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target.$urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    } else {
                        $marca_id = 0;
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
                        'url' => 291,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;

            endforeach;
        endforeach;


        //Chile_Falabella_Mobile_Category_Organic Tv
        $requestFalabellaDeskCatOrg= $client->request('GET', 'https://extraction.import.io/query/extractor/22e814af-da58-46fb-a762-5c3bfe1f523f?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.falabella.com%2Ffalabella-cl%2Fcategory%2Fcat1012%2FTV',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestFalabellaDeskCatOrg =  json_decode($requestFalabellaDeskCatOrg->getBody(), true);

        $dadosFalabellaDeskCatOrg = $requestFalabellaDeskCatOrg['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestFalabellaDeskCatOrg['url'];


        foreach ( $dadosFalabellaDeskCatOrg as $dado):


            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Chile_".$lojaNome."_Mobile_Category_Organic_Tv_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target.$urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    } else {
                        $marca_id = 0;
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
                        'url' => 292,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;

            endforeach;
        endforeach;


        //Chile_Falabella_Desktop_Category_Organic Tv
        $requestFalabellaDeskCatOrg= $client->request('GET', 'https://extraction.import.io/query/extractor/22e814af-da58-46fb-a762-5c3bfe1f523f?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.falabella.com%2Ffalabella-cl%2Fcategory%2Fcat1012%2FTV',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestFalabellaDeskCatOrg =  json_decode($requestFalabellaDeskCatOrg->getBody(), true);

        $dadosFalabellaDeskCatOrg = $requestFalabellaDeskCatOrg['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestFalabellaDeskCatOrg['url'];


        foreach ( $dadosFalabellaDeskCatOrg as $dado):


            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Chile_".$lojaNome."_Desktop_Category_Organic_Tv_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target.$urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    } else {
                        $marca_id = 0;
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
                        'url' => 99,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;

            endforeach;
        endforeach;


        //Chile_Falabella_Desktop_Category_Organic Lavadora
        $requestFalabellaDeskCatOrg= $client->request('GET', 'https://extraction.import.io/query/extractor/22e814af-da58-46fb-a762-5c3bfe1f523f?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.falabella.com%2Ffalabella-cl%2Fcategory%2Fcat4060%2FLavadoras',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestFalabellaDeskCatOrg =  json_decode($requestFalabellaDeskCatOrg->getBody(), true);

        $dadosFalabellaDeskCatOrg = $requestFalabellaDeskCatOrg['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestFalabellaDeskCatOrg['url'];


        foreach ( $dadosFalabellaDeskCatOrg as $dado):


            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Chile_".$lojaNome."_Desktop_Category_Organic_Maquina_lavar_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target.$urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    } else {
                        $marca_id = 0;
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
                        'url' => 141,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;

            endforeach;
        endforeach;

        //Chile_Falabella_Mobile_Category_Organic Lavadora
        $requestFalabellaDeskCatOrg= $client->request('GET', 'https://extraction.import.io/query/extractor/22e814af-da58-46fb-a762-5c3bfe1f523f?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.falabella.com%2Ffalabella-cl%2Fcategory%2Fcat4060%2FLavadoras',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestFalabellaDeskCatOrg =  json_decode($requestFalabellaDeskCatOrg->getBody(), true);

        $dadosFalabellaDeskCatOrg = $requestFalabellaDeskCatOrg['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestFalabellaDeskCatOrg['url'];


        foreach ( $dadosFalabellaDeskCatOrg as $dado):


            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Chile_".$lojaNome."_Mobile_Category_Organic_Maquina_lavar_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target.$urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    } else {
                        $marca_id = 0;
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
                        'url' => 293,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;

            endforeach;
        endforeach;

        //Chile_Falabella_Desktop_Category_Organic Geladeira
        $requestFalabellaDeskCatOrg= $client->request('GET', 'https://extraction.import.io/query/extractor/22e814af-da58-46fb-a762-5c3bfe1f523f?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.falabella.com%2Ffalabella-cl%2Fcategory%2Fcat4074%2FNo-Frost',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestFalabellaDeskCatOrg =  json_decode($requestFalabellaDeskCatOrg->getBody(), true);

        $dadosFalabellaDeskCatOrg = $requestFalabellaDeskCatOrg['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestFalabellaDeskCatOrg['url'];


        foreach ( $dadosFalabellaDeskCatOrg as $dado):


            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Chile_".$lojaNome."_Desktop_Category_Organic_Geladeira_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target.$urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    } else {
                        $marca_id = 0;
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
                        'url' => 14,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;

            endforeach;
        endforeach;


        //Chile_Falabella_Mobile_Category_Organic Geladeira
        $requestFalabellaDeskCatOrg= $client->request('GET', 'https://extraction.import.io/query/extractor/22e814af-da58-46fb-a762-5c3bfe1f523f?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.falabella.com%2Ffalabella-cl%2Fcategory%2Fcat4074%2FNo-Frost',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type'=> 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $requestFalabellaDeskCatOrg =  json_decode($requestFalabellaDeskCatOrg->getBody(), true);

        $dadosFalabellaDeskCatOrg = $requestFalabellaDeskCatOrg['extractorData']["data"];
        $position = 1;
        $urlTipo = $requestFalabellaDeskCatOrg['url'];


        foreach ( $dadosFalabellaDeskCatOrg as $dado):


            foreach ($dado["group"]  as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image= base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Chile_".$lojaNome."_Mobile_Category_Organic_Geladeira_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target.$urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    } else {
                        $marca_id = 0;
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
                        'url' => 290,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;

            endforeach;
        endforeach;










        //Chile_Falabella_Desktop_Homepage_Ads
    $requestFalabellaDeskHomAds= $client->request('GET', 'https://data.import.io/extractor/ecad15ed-2108-4bc1-8cba-b5494113b49a/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
        [
            'headers' => [
                'Accept' => 'application/json',
                'Content-type'=> 'application/json',
                'Accept-Encoding' => 'gzip'
            ]
        ]);

    $requestFalabellaDeskHomAds =  json_decode($requestFalabellaDeskHomAds->getBody(), true);

    $dadosFalabellaDeskHomAds = $requestFalabellaDeskHomAds['result']['extractorData']["data"];
    $position = 1;

    $urlTipo = $requestFalabellaDeskHomAds['url'];


    foreach ( $dadosFalabellaDeskHomAds as $dado):

        foreach ($dado["group"]  as $value):

            if (isset($value["Image"][0]["src"])) {

                $imagem = $value["Image"][0]["src"];
                $image = @file_get_contents($imagem);
                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Chile_".$lojaNome."_Desktop_Homepage_Ads_".$data.$turno.$position.".jpg";
                $im = @imagecreatefromstring($image);
                header("Content-type: image/jpg");
                @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0]."/".$dt[1]."/". $name);

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
                    'tipo_pagina_id' => 3,
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

    //Chile_Falabella_Desktop_Homepage_Organic
    $requestFalabellaDeskHomOrg= $client->request('GET', 'https://data.import.io/extractor/ac33d40f-3c16-49d8-ba16-8d271eb8fe31/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
        [
            'headers' => [
                'Accept' => 'application/json',
                'Content-type'=> 'application/json',
                'Accept-Encoding' => 'gzip'
            ]
        ]);

    $requestFalabellaDeskHomOrg =  json_decode($requestFalabellaDeskHomOrg->getBody(), true);

    $dadosFalabellaDeskHomAds = $requestFalabellaDeskHomOrg['result']['extractorData']["data"];
    $position = 1;

    $urlTipo = $requestFalabellaDeskHomOrg['url'];
    $timestamp = $requestFalabellaDeskHomOrg["result"]["timestamp"];
    $date = new \DateTime();
    $date->setTimestamp($timestamp);
    $date_captura = date_format($date, 'U = Y-m-d H:i:s');

    foreach ( $dadosFalabellaDeskHomAds as $dado):

        foreach ($dado["group"]  as $value):

            if (isset($value["Image"][0]["src"])) {

                $imagem = $value["Image"][0]["src"];
                $image = @file_get_contents($imagem);
                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Chile_".$lojaNome."_Desktop_Homepage_Organic_".$data.$turno.$position.".jpg";
                $im = @imagecreatefromstring($image);
                header("Content-type: image/jpg");
                @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0]."/".$dt[1]."/". $name);

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

    //Chile_Falabella_Desktop_Homepage_Carousel
    $requestFalabellaDeskHomCarousel= $client->request('GET', 'https://extraction.import.io/query/extractor/59cb7ce5-d065-4977-8d36-02ab9edaac0b?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=http%3A%2F%2Fwww.falabella.com%2Ffalabella-cl%2F',
        [
            'headers' => [
                'Accept' => 'application/json',
                'Content-type'=> 'application/json',
                'Accept-Encoding' => 'gzip'
            ]
        ]);

    $requestFalabellaDeskHomCarousel =  json_decode($requestFalabellaDeskHomCarousel->getBody(), true);

    $dadosFalabellaDeskHomCarousel = $requestFalabellaDeskHomCarousel['extractorData']["data"];
    $position = 1;

    $urlTipo = $requestFalabellaDeskHomCarousel['url'];

    foreach ( $dadosFalabellaDeskHomCarousel as $dado):

        foreach ($dado["group"]  as $value):

            if (isset($value["Image"][0]["src"])) {

                $imagem = $value["Image"][0]["src"];
                $image = @file_get_contents($imagem);
                $image= base64_encode($image);
                $image = base64_decode($image);
                $name = "Chile_".$lojaNome."_Desktop_Homepage_Carousel_".$data.$turno.$position.".jpg";
                $im = @imagecreatefromstring($image);
                header("Content-type: image/jpg");
                @imagejpeg($im, "/var/www/html/retail/public/printshtml/chile/desktop/".$dt[0]."/".$dt[1]."/". $name);

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
                    'tipo_pagina_id' => 2,
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

    }
}
