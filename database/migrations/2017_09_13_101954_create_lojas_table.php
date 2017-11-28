<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLojasTable extends Migration
{
    public function up()
    {
        Schema::create('lojas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('paises');
            $table->text('descricao');
            $table->text('url');
            $table->time('hora1');
            $table->time('hora2');
            $table->time('hora3');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('lojas');

    }
}
