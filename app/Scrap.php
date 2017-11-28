<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scrap extends Model
{
    protected $fillable = [
        'pais_id',
        'tipo_pagina_id',
        'categoria_id',
        'marca_id',
        'loja_id',
        'tipo_anincio_id',
        'turno',
        'device',
        'place',
        'position',
        'imagem',
        'arquivo',
        'target',
        'type',
        'titulo',
        'produto',
        'detalhe',
        'call_action',
        'preco',
        'preco_promocao',
        'preco_inicial',
        'detalhe_tipo_anuncio'
    ];

    protected $table = 'scraps';

    public function pais()
    {
        return $this->beLongsTo('App\Pais');
    }

    public function loja()
    {
        return $this->belongsTo('App\Loja');
    }
}
