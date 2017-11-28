<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Urlbox\Screenshots\Facades\Urlbox;
use DB;
use App\Marca;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;


class CreateActiveAbcdin extends Command
{

    protected $signature = 'CreateActiveAbcdin:insert';
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

        $mes = (int)$dt[1];
        $dh = explode(" ", $dt[2]);
        $dia = (int)$dh[0];
        $data = $dt[0] . "_" . $mes . "_" . $dia;

        $horaG1 = strtotime('03:00');

        $horaG2 = strtotime('11:00');

        $horaG3 = strtotime('19:00');

        $horaAtual = strtotime(date('H:i'));

        if ($horaAtual >= $horaG1 && $horaAtual < $horaG2) {
            $turno = "G1";
        } elseif ($horaAtual >= $horaG2 && $horaAtual < $horaG3) {
            $turno = "G2";
        } elseif ($horaAtual >= $horaG3) {
            $turno = "G3";
        }

        //criacao de diretorio desktop
        if (!is_dir("/var/www/html/retail/public/screenshots/colombia/desktop/" . $dt[0])) {
            mkdir("/var/www/html/retail/public/screenshots/colombia/desktop/" . $dt[0], 0777);
        }

        if (!is_dir("/var/www/html/retail/public/screenshots/colombia/desktop/" . $dt[0] . "/" . $dt[1])) {
            mkdir("/var/www/html/retail/public/screenshots/colombia/desktop/" . $dt[0] . "/" . $dt[1], 0777);
        }
        //criacao de desktop mobile
        if (!is_dir("/var/www/html/retail/public/screenshots/colombia/mobile/" . $dt[0])) {
            mkdir("/var/www/html/retail/public/screenshots/colombia/mobile/" . $dt[0], 0777);
        }

        if (!is_dir("/var/www/html/retail/public/screenshots/colombia/mobile/" . $dt[0] . "/" . $dt[1])) {
            mkdir("/var/www/html/retail/public/screenshots/colombia/mobile/" . $dt[0] . "/" . $dt[1], 0777);
        }

        //Colombia
        $lojadb = DB::table('lojas')->where('descricao', 'Abcdin')->first();
        $loja_id = $lojadb->id;
        $pais_id = $lojadb->pais_id;
        $lojaNome = "Abcdin";


        //Colombia
        $urslDesktopChile = [
            //abcdin
            'abcdin.cl',
            'abcdin.cl/tienda/es/abcdin/celulares/smartphones#facet:&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&',
            'abcdin.cl/tienda/es/abcdin/tv-audio/televisores-video/televisores-led#facet:&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&',
            'abcdin.cl/tienda/es/abcdin/linea-blanca/refrigeradores#facet:&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&',
            'abcdin.cl/tienda/es/abcdin/linea-blanca/lavado-secado#facet:&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&',
        ];

        $contchileD = 0;

        foreach ($urslDesktopChile as $value):

            $grupo = explode(".", $value);
            if ($grupo[0] == 'm') {
                $loja = $grupo[1];
            } else {
                $loja = $grupo[0];
            }
            $loja = ucfirst($loja);

            if ($contchileD == 0) {
                $tipo = 'Homepage_';
            } elseif ($contchileD == 1) {
                $tipo = 'Smartphones_';
            } elseif ($contchileD == 2) {
                $tipo = 'TVs_';
            } elseif ($contchileD == 3) {
                $tipo = 'Refrigerators_';
            } elseif ($contchileD == 4) {
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

                $image = base64_encode($image);
                $image = base64_decode($image);
                $name = "Colombia_" . $loja . "_Desktop_" . $tipo . $data . $turno . ".jpg";
                $im = @imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                @imagejpeg($im, "/var/www/html/retail/public/screenshots/colombia/desktop/" . $dt[0] . "/" . $dt[1] . "/" . $name);

                DB::table('screenshots')->insert(
                    [
                        'pais_id' => $pais_id,
                        'loja_id' => $loja_id,
                        'tipo_pagina' => $tipo,
                        'device' => 'Desktop',
                        'link' => $urlboxUrl,
                        'arquivo' => $name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );

            } else {
                echo 'Ocorreu um erro.';

            }
            $contchileD++;
        endforeach;

        $urslMobileChile = [
            //abcdin
            'abcdin.cl',
            'abcdin.cl/tienda/es/abcdin/celulares/smartphones#facet:&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&',
            'abcdin.cl/tienda/es/abcdin/tv-audio/televisores-video/televisores-led#facet:&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&',
            'abcdin.cl/tienda/es/abcdin/linea-blanca/refrigeradores#facet:&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&',
            'abcdin.cl/tienda/es/abcdin/linea-blanca/lavado-secado#facet:&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&',
        ];

        $contchileM = 0;

        foreach ($urslMobileChile as $value):


            if ($contchileM == 0) {
                $tipo = 'Homepage_';
            } elseif ($contchileM == 1) {
                $tipo = 'Smartphones_';
            } elseif ($contchileM == 2) {
                $tipo = 'TVs_';
            } elseif ($contchileM == 3) {
                $tipo = 'Refrigerators_';
            } elseif ($contchileM == 4) {
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

                $image = base64_encode($image);
                $image = base64_decode($image);
                $name = "Colombia_" . $loja . "_Mobile_" . $tipo . $data . $turno . ".jpg";
                $im = @imagecreatefromstring($image);
                header('Content-Type: image/jpg');
                @imagejpeg($im, "/var/www/html/retail/public/screenshots/colombia/mobile/" . $dt[0] . "/" . $dt[1] . "/" . $name);

                DB::table('screenshots')->insert(
                    [
                        'pais_id' => $pais_id,
                        'loja_id' => $loja_id,
                        'tipo_pagina' => $tipo,
                        'device' => 'Mobile',
                        'link' => $urlboxUrl,
                        'arquivo' => $name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );

            } else {
                echo 'Ocorreu um erro.';

            }
            $contchileM++;
        endforeach;

        //import.io
        //criação diretório desktop
        if (!is_dir("/var/www/html/retail/public/printshtml/colombia/desktop/" . $dt[0])) {
            mkdir("/var/www/html/retail/public/printshtml/colombia/desktop/" . $dt[0], 0777);
        }

        if (!is_dir("/var/www/html/retail/public/printshtml/colombia/desktop/" . $dt[0] . "/" . $dt[1])) {
            mkdir("/var/www/html/retail/public/printshtml/colombia/desktop/" . $dt[0] . "/" . $dt[1], 0777);
        }
        //criacao diretório mobile
        if (!is_dir("/var/www/html/retail/public/printshtml/colombia/mobile/" . $dt[0])) {
            mkdir("/var/www/html/retail/public/printshtml/colombia/mobile/" . $dt[0], 0777);
        }

        if (!is_dir("/var/www/html/retail/public/printshtml/colombia/mobile/" . $dt[0] . "/" . $dt[1])) {
            mkdir("/var/www/html/retail/public/printshtml/colombia/mobile/" . $dt[0] . "/" . $dt[1], 0777);
        }

        //Chile_ABCdin_Desktop_Homepage_Carousel
        $request = $client->request('GET', 'https://data.import.io/extractor/9cd76f79-611f-4c35-89ec-ab54387531e7/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $request = json_decode($request->getBody(), true);
        $dadosRequest = $request['result']['extractorData']["data"];
        $position = 1;

        $urlTipo = $request['url'];
        $timestamp = $request["result"]["timestamp"];

        foreach ($dadosRequest as $dado):

            foreach ($dado["group"] as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image = base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Colombia_" . $lojaNome . "_Desktop_Homepage_Carousel_" . $data . $turno . $position . ".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/desktop/" . $dt[0] . "/" . $dt[1] . "/" . $name);

                } else {
                    $imagem = "";
                    $name = "";
                }

                if (isset($value["Target URL"][0]["text"])) {
                    $target = $value["Target URL"][0]["text"];
                } else {
                    $target = "";
                }

                if (isset($value["Place"][0]["text"])) {
                    $place = $value["Place"][0]["text"];
                } else {
                    $place = "";
                }

                if (isset($value["Title"][0]["text"])) {
                    $titulo = $value["Title"][0]["text"];

                } else {
                    $titulo = "";
                }

                if (isset($value["Call to Action"][0]["text"])) {
                    $callEction = $value["Call to Action"][0]["text"];
                } else {
                    $callEction = "";
                }

                if (isset($value["Price"][0]["text"])) {
                    $preco = $value["Price"][0]["text"];
                } else {
                    $preco = "";
                }

                if (isset($value["Price From"][0]["text"])) {
                    $price_from = @$value["Price From"][0]["text"];
                } else {
                    $price_from = "";
                }

                if (isset($value["Price Install"][0]["text"])) {
                    $price_install = $value["Price Install"][0]["text"];
                } else {
                    $price_install = "";
                }

                if (isset($value["Product"][0]["text"])) {
                    $produto = $value["Product"][0]["text"];
                } else {
                    $produto = "";
                }

                if (isset($value["Type"][0]["text"])) {
                    $type = $value["Type"][0]["text"];
                } else {
                    $type = "";
                }

                $string = $titulo . $produto . $target . $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if ($buscaMarca) {
                        $marca_id = (int)$marca->id;
                    } else {
                        $marca_id = 0;
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
                $position++;
            endforeach;
        endforeach;
        //Chile_ABCdin_Mobile_Homepage_Carousel
        $request = $client->request('GET', 'https://data.import.io/extractor/9cd76f79-611f-4c35-89ec-ab54387531e7/json/latest?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                    'Accept-Encoding' => 'gzip'
                ]
            ]);

        $request = json_decode($request->getBody(), true);
        $dadosRequest = $request['result']['extractorData']["data"];
        $position = 1;

        $urlTipo = $request['url'];

        foreach ($dadosRequest as $dado):

            foreach ($dado["group"] as $value):

                if (isset($value["Image"][0]["src"])) {

                    $imagem = $value["Image"][0]["src"];
                    $image = @file_get_contents($imagem);
                    $image = base64_encode($image);
                    $image = base64_decode($image);
                    $name = "Colombia_" . $lojaNome . "_Mobile_Homepage_Carousel_" . $data . $turno . $position . ".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/mobile/" . $dt[0] . "/" . $dt[1] . "/" . $name);

                } else {
                    $imagem = "";
                    $name = "";
                }

                if (isset($value["Target URL"][0]["text"])) {
                    $target = $value["Target URL"][0]["text"];
                } else {
                    $target = "";
                }

                if (isset($value["Place"][0]["text"])) {
                    $place = $value["Place"][0]["text"];
                } else {
                    $place = "";
                }

                if (isset($value["Title"][0]["text"])) {
                    $titulo = $value["Title"][0]["text"];

                } else {
                    $titulo = "";
                }

                if (isset($value["Call to Action"][0]["text"])) {
                    $callEction = $value["Call to Action"][0]["text"];
                } else {
                    $callEction = "";
                }

                if (isset($value["Price"][0]["text"])) {
                    $preco = $value["Price"][0]["text"];
                } else {
                    $preco = "";
                }

                if (isset($value["Price From"][0]["text"])) {
                    $price_from = @$value["Price From"][0]["text"];
                } else {
                    $price_from = "";
                }

                if (isset($value["Price Install"][0]["text"])) {
                    $price_install = $value["Price Install"][0]["text"];
                } else {
                    $price_install = "";
                }

                if (isset($value["Product"][0]["text"])) {
                    $produto = $value["Product"][0]["text"];
                } else {
                    $produto = "";
                }

                if (isset($value["Type"][0]["text"])) {
                    $type = $value["Type"][0]["text"];
                } else {
                    $type = "";
                }


                $string = $titulo . $produto . $target . $urlTipo;


                foreach ($marcas as $marca):
                    $buscaMarca = strstr($string, $marca->descricao);
                    if ($buscaMarca) {
                        $marca_id = (int)$marca->id;
                    } else {
                        $marca_id = 0;
                    }
                endforeach;

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

        //Chile_ABCdin_Desktop_Category_Organic celuar
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/ffa69e5b-32c5-4b0c-8be4-d8da75959365?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2Ftienda%2Fes%2Fabcdin%2Fcelulares%2Fsmartphones%23facet%3A%26productBeginIndex%3A0%26orderBy%3A%26pageView%3Agrid%26minPrice%3A%26maxPrice%3A%26pageSize%3A%26',
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
                    $name = "Colombia_".$lojaNome."_Desktop_Category_Organic_Celular_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/desktop/".$dt[0]."/".$dt[1]."/".$name);

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


                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca):

                    $buscaMarca = strstr($string, $marca->descricao);
                    if ($buscaMarca) {
                        $marca_id = (int)$marca->id;
                    } else {
                        $marca_id = 0;
                    }
                endforeach;

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
                        'url' => 66,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;

        //Chile_ABCdin_Mobile_Category_Organic celuar
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/ffa69e5b-32c5-4b0c-8be4-d8da75959365?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2Ftienda%2Fes%2Fabcdin%2Fcelulares%2Fsmartphones%23facet%3A%26productBeginIndex%3A0%26orderBy%3A%26pageView%3Agrid%26minPrice%3A%26maxPrice%3A%26pageSize%3A%26',
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
                    $name = "Colombia_".$lojaNome."_Mobile_Category_Organic_Celular_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/mobile/".$dt[0]."/".$dt[1]."/".$name);

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


                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca):

                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int) $marca->id;
                    } else {
                        $marca_id = 0;
                    }
                 endforeach;

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
                        'url' => 173,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;

        //Chile_ABCdin_Desktop_Category_Organic TV
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/ffa69e5b-32c5-4b0c-8be4-d8da75959365?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2Ftienda%2Fes%2Fabcdin%2Ftv-audio%2Ftelevisores-led%23facet%3A%26productBeginIndex%3A0%26orderBy%3A%26pageView%3Agrid%26minPrice%3A%26maxPrice%3A%26pageSize%3A%26',
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
                    $name = "Colombia_".$lojaNome."_Desktop_Category_Organic_Tv_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/desktop/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }else {
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
                        'url' => 122,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;

        //Chile_ABCdin_Mobile_Category_Organic TV
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/ffa69e5b-32c5-4b0c-8be4-d8da75959365?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2Ftienda%2Fes%2Fabcdin%2Ftv-audio%2Ftelevisores-led%23facet%3A%26productBeginIndex%3A0%26orderBy%3A%26pageView%3Agrid%26minPrice%3A%26maxPrice%3A%26pageSize%3A%26',
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
                    $name = "Colombia_".$lojaNome."_Mobile_Category_Organic_Tv_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {

                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }else {
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
                        'url' => 174,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Chile_ABCdin_Desktop_Category_Organic Refrigerador
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/ffa69e5b-32c5-4b0c-8be4-d8da75959365?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2Ftienda%2Fes%2Fabcdin%2Flinea-blanca%2Frefrigeradores%23facet%3A%26productBeginIndex%3A0%26orderBy%3A%26pageView%3Agrid%26minPrice%3A%26maxPrice%3A%26pageSize%3A%26',
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
                    $name = "Colombia_".$lojaNome."_Desktop_Category_Organic_Geladeira_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/desktop/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }else {
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
                        'url' => 27,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Chile_ABCdin_Mobile_Category_Organic Refrigerador
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/ffa69e5b-32c5-4b0c-8be4-d8da75959365?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2Ftienda%2Fes%2Fabcdin%2Flinea-blanca%2Frefrigeradores%23facet%3A%26productBeginIndex%3A0%26orderBy%3A%26pageView%3Agrid%26minPrice%3A%26maxPrice%3A%26pageSize%3A%26',
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
                    $name = "Colombia_".$lojaNome."_Mobile_Category_Organic_Geladeira_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }else {
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
                        'url' => 172,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;

        //Chile_ABCdin_Desktop_Category_Organic Maqueina de Larvar
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/ffa69e5b-32c5-4b0c-8be4-d8da75959365?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2Ftienda%2Fes%2Fabcdin%2Flinea-blanca%2Flavado-secado%23facet%3A%26productBeginIndex%3A0%26orderBy%3A%26pageView%3Agrid%26minPrice%3A%26maxPrice%3A%26pageSize%3A%26',
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
                    $name = "Colombia_".$lojaNome."_Desktop_Category_Organic_Maquina_Lavar_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/desktop/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }else {
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
                        'url' => 155,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Chile_ABCdin_Desktop_Category_Organic Maqueina de Larvar
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/ffa69e5b-32c5-4b0c-8be4-d8da75959365?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2Ftienda%2Fes%2Fabcdin%2Flinea-blanca%2Flavado-secado%23facet%3A%26productBeginIndex%3A0%26orderBy%3A%26pageView%3Agrid%26minPrice%3A%26maxPrice%3A%26pageSize%3A%26',
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
                    $name = "Colombia_".$lojaNome."_Mobile_Category_Organic_Maquina_Lavar_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }else {
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
                        'url' => 175,
                        'detalhe_tipo_anuncio' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $position ++;
            endforeach;
        endforeach;


        //Chile_ABCdin_Desktop_Homepage_Ads
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/307e57a5-eb61-445b-ac6b-1dd22a9a09bc?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2F',
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
                    $name = "Colombia_".$lojaNome."_Desktop_Homepage_Ads_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/desktop/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {

                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;

                    }else {
                        $marca_id = 0;
                    }

                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 3,
                        'categoria_id' => '1',
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


        //Chile_ABCdin_Mobile_Homepage_Ads
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/307e57a5-eb61-445b-ac6b-1dd22a9a09bc?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2F',
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
                    $name = "Colombia_".$lojaNome."_Desktop_Homepage_Ads_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca):

                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }else {
                        $marca_id = 0;
                    }
                endforeach;

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => 3,
                        'categoria_id' => '1',
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


        //Chile_ABCdin_Desktop_Homepage_Organic
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/022ecd5b-7e21-4f77-bbdf-380fca0156af?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2F',
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
                    $name = "Colombia_".$lojaNome."_Desktop_Homepage_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/desktop/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {
                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;
                    }else {
                        $marca_id = 0;
                    }
                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => '1',
                        'categoria_id' => '1',
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

        //Chile_ABCdin_Mobile_Homepage_Organic
        $request = $client->request('GET', 'https://extraction.import.io/query/extractor/022ecd5b-7e21-4f77-bbdf-380fca0156af?_apikey=69b08086c8674326a53d8fd4a633d2e1a273e2ba260a9b39370e3019dd5397ec97f44c04dd3689aaca2d341ee9caab71434d3d5bae7c9f3be80fbaf63465aa2a3a1cb897066c9c10296a6181dc2dcf2e&url=https%3A%2F%2Fwww.abcdin.cl%2F',
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
                    $name = "Colombia_".$lojaNome."_Mobile_Homepage_Organic_".$data.$turno.$position.".jpg";
                    $im = @imagecreatefromstring($image);
                    header("Content-type: image/jpg");
                    @imagejpeg($im, "/var/www/html/retail/public/printshtml/colombia/mobile/".$dt[0]."/".$dt[1]."/".$name);

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

                $string = $titulo.$produto.$target. $urlTipo;

                foreach ($marcas as $marca) {

                    $buscaMarca = strstr($string, $marca->descricao);
                    if($buscaMarca){
                        $marca_id = (int)$marca->id;

                    }else {
                        $marca_id = 0;
                    }

                }

                DB::table('scraps')->insertGetId(
                    [
                        'pais_id' => $pais_id,
                        'tipo_pagina_id' => '1',
                        'categoria_id' => '1',
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
