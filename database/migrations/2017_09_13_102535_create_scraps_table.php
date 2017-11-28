<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrapsTable extends Migration
{
    public function up()
    {
        Schema::create('scraps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('paises');
            $table->integer('tipo_pagina_id')->unsigned();
            $table->foreign('tipo_pagina_id')->references('id')->on('tipo_pagina');
            $table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->integer('marca_id')->unsigned();
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->integer('loja_id')->unsigned();
            $table->foreign('loja_id')->references('id')->on('lojas');
            $table->integer('tipo_anuncio_id')->unsigned();
            $table->foreign('tipo_anuncio_id')->references('id')->on('tipo_anuncios');
            $table->string('turno', 250);
            $table->string('device', 250);
            $table->string('place', 250);
            $table->string('position', 250);
            $table->text('imagem');
            $table->text('arquivo');
            $table->text('target');
            $table->string('type', 250);
            $table->string('titulo', 250);
            $table->string('produto', 250);
            $table->string('detalhe', 250);
            $table->string('call_action', 250);
            $table->string('preco', 250);
            $table->string('preco_promocao', 250);
            $table->string('preco_inicial', 250);
            $table->string('detalhe_tipo_anuncio', 250);
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('htmls');
    }
}
