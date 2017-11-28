<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScreenshotsTable extends Migration
{
    public function up()
    {
        Schema::create('screenshots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('paises');
            $table->text('link');
            $table->text('arquivo');
            $table->timestamps();
        });

    }


    public function down()
    {
        Schema::dropIfExists('screenshots');
    }
}
