<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoPaginasTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_paginas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_pagina');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('tipo_paginas');

    }
}
