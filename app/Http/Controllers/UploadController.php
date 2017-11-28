<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Urlbox\Screenshots\Facades\Urlbox;
use DB;
use App\Marca;
use App\Loja;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;


class UploadController extends Controller
{

    public function index()
    {
        $lojas = Loja::get()->pluck('descricao', 'id');

        return view('upload.index' ,  compact('lojas'));

    }

    public function create( Request $request)
    {

        foreach($_FILES as $index => $file) {

            $fileName = $file['name'];
            $fileTempName = $file['tmp_name'];

            if (!empty($file['error'][$index])) {
                return false;
            }

            if (!empty($fileTempName) && is_uploaded_file($fileTempName)) {

                $diretorio = "/var/www/html/retail/public/uploader/".$fileName;

                if(!file_exists($diretorio)) {

                    move_uploaded_file($fileTempName, $diretorio);

                    $marcas = Marca::all();

                    $marca_id = 0;


                    $data = date('Y_m_d H:i:s');
                    $dt = explode('_', $data);

                    $mes = (int) $dt[1];
                    $dh = explode(" ", $dt[2]);
                    $dia = (int) $dh[0];
                    $data = $dt[0]."_". $mes ."_". $dia;

                    $horaG1 = strtotime('03:00:00');
                    $horaG2 = strtotime('11:00:00');
                    $horaG3 = strtotime('19:00:00');



                    $loja = $_POST['loja_id'];
                    $lojadb = DB::table('lojas')->where('id', $loja)->first();
                    $loja_id = $lojadb->id;
                    $pais_id = $lojadb->pais_id;
                    $lojaNome = $lojadb->descricao;

                    $pais = DB::table('paises')->where('id', $lojadb->pais_id)->first();
                    $paisBusca = strtolower($pais->pais);
                    $nomePais = $pais->pais;


                    $nome = $file['name'];
                    $data = explode('---', $nome);
                    $dt = explode("T", $data[1]);
                    $hora = explode(".", $dt[1]);
                    $hora = chunk_split($hora[0], 2, ':');
                    $hora = str_split($hora, 8);

                    $d = explode("-", $dt[0]);

                    //criacao de diretorio desktop
                   /* if(!is_dir("/var/www/html/retail/public/printshtml/'.$paisBusca.'/desktop/".$d[0])) {
                        mkdir("/var/www/html/retail/public/printshtml/'.$paisBusca.'/desktop/".$d[0], 0777);
                    }

                    if(!is_dir("/var/www/html/retail/public/printshtml/'.$paisBusca.'/desktop/".$d[0]."/".$d[1])){
                       mkdir("/var/www/html/retail/public/printshtml/'.$paisBusca.'/desktop/".$d[0]."/".$d[1], 0777);
                    }*/

                $createdet = $dt[0]." ".$hora[0];
                    $horaAtual = strtotime($hora[0]);

                    if ($horaAtual >= $horaG1 && $horaAtual < $horaG2) {
                        $turno = "G1";
                    } elseif ($horaAtual >= $horaG2 && $horaAtual < $horaG3){
                        $turno = "G2";
                    } else  {
                        $turno = "G3";
                    }


                    $foo = $this->getCSV($diretorio);


                    foreach ($foo as $value):
                        
                    $value = explode("\",\"",$value);

                        $value[0] = str_replace("\"","",$value[0]);
                        $urlTipo = $value[0];

                        if(isset($value[2])) {
                            $value[2] = str_replace("\"","",$value[2]);
                            $position = $value[2];
                        } else {
                            $position = "";
                        }

                        if (isset($value[3])) {
                            $value[3] = str_replace("\"","",$value[3]);
                            $imagem = $value[3];
                            $image = @file_get_contents($imagem);
                            $image = base64_encode($image);
                            $image = base64_decode($image);
                            $name = $nomePais."_".$lojaNome."_Search_".$dt[0].$turno.$position.".jpg";
                            $im = @imagecreatefromstring($image);
                            header("Content-type: image/jpg");
                            @imagejpeg($im, "/var/www/html/retail/public/printshtml/'.$paisBusca.'/desktop/".$d[0]."/".$d[1]."/".$name);

                        } else {
                            $imagem = "";
                        }

                        if (isset($value[4])){
                            $value[4] = str_replace("\"","",$value[4]);
                            $target = $value[4];
                        } else {
                            $target = "";
                        }

                        if (isset($value[9])) {
                            $value[9] = str_replace("\"","",$value[9]);
                            $titulo = $value[9];

                        } else {
                            $titulo = "";
                        }

                        if (isset($value[11])){
                            $value[11] = str_replace("\"","",$value[11]);
                            $callEction = $value[11];
                        } else {
                            $callEction = "";
                        }

                        if (isset($value[12])){
                            $value[12] = str_replace("\"","",$value[12]);
                            if(!empty($value[12]) || $value[12] != 'R$'){
                                $value[13] = str_replace("\"","",$value[13]);
                                //$valor = $value[12] ."," .$value[13];
                                $valor = $value[12];
                                $preco = $valor ;
                            } else {
                                $preco = "";
                            }


                        } else {
                            $preco = "";
                        }


                        if(isset($value[13])) {

                            $value[13] = str_replace("\"","",$value[14]);
                            $value[14] = str_replace("\"","",$value[15]);
                            $valorP = $value[13];
                            $price_from= $valorP;
                        } else {
                            $price_from= "";
                        }

                        if(isset($value[14])) {
                            $value[14] = str_replace("\"","",$value[14]);
                            $price_install = $value[15];
                        } else {
                            $price_install = "";
                        }

                        if(isset($value[8])) {
                            $value[8] = str_replace("\"","",$value[8]);
                            $produto = $value[8];
                        } else {
                            $produto = "";
                        }

                        if(isset($value[5])) {
                            $value[5] = str_replace("\"","",$value[5]);
                            $type = $value[5];
                        } else {
                            $type = "";
                        }


                        if(isset($value[15])) {
                            $value[15] = str_replace("\"","",$value[15]);
                            $ad_type = $value[15];
                        } else {
                            $ad_type = "";
                        }

                        if(isset($value[16])) {
                            $value[16] = str_replace("\"","",$value[16]);
                            $detalhe_tipo_anuncio = $value[16];
                        } else {
                            $detalhe_tipo_anuncio = "";
                        }

                        if(isset( $value[10])) {
                            $value[10] = str_replace("\"","",$value[10]);
                            $detalhe = $value[10];
                        } else {
                            $detalhe = "";
                        }

                        if (isset($value[1])){
                            $value[1] = str_replace("\"","",$value[1]);
                            $place = $value[1];
                        } else {
                            $place = "";
                        }


                        $string = $titulo.$produto.$target. $urlTipo;

                        foreach ($marcas as $marca) {
                            $buscaMarca = strstr($string, $marca->descricao);
                            $buscaMarcaDesc = strstr($string, $marca->descricao_outros);
                            if($buscaMarca || $buscaMarcaDesc){
                                $marca_id = $marca->id;
                            }
                        }

                        DB::table('scraps')->insertGetId(
                            [
                                'pais_id' => $pais_id,
                                'tipo_pagina_id' => 6,
                                'categoria_id' => 7,
                                'marca_id' => $marca_id,
                                'loja_id' => $loja_id,
                                'tipo_anuncio_id' => '1',
                                'turno' => $turno,
                                'device' => '',
                                'place' => $place,
                                'position' => $position,
                                'imagem' => $imagem,
                                'arquivo' => $name,
                                'target' => $target,
                                'type' => $type,
                                'titulo' => $titulo,
                                'produto' => $produto,
                                'detalhe' => $detalhe,
                                'call_action' => $callEction,
                                'preco' => $preco,
                                'price_from' => $price_from,
                                'price_install' => $price_install,
                                'url' => $urlTipo,
                                'detalhe_tipo_anuncio' => $detalhe_tipo_anuncio,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'ad_type' => '',
                                'created_at' => $createdet,
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                    endforeach;

                    echo '<p><strong>' . $fileName . '</strong> OK.</p>';
                } else {
                    echo  'Arquivo já existe. Verifique pasta uploader!';
                }
                }

            }

    }


    function getCSV($name) {

        $file = fopen($name, "r");
        $result = array();
        $i = 0;
        while (!feof($file)):
            if (substr(($result[$i] = fgets($file)), 0, 10) !== ';;;;;;;;') :
                $i++;
            endif;
        endwhile;
        fclose($file);
        return $result;
    }



}
