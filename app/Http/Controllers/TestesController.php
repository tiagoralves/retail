<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;

class TestesController extends Controller
{
    public function  testes(){
       $marcas = Marca::all();

        var_dump($marcas); exit;

    }
}
