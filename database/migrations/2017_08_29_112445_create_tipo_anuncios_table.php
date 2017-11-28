<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoAnunciosTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_anuncios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('tipo_anuncios');

    }
}
