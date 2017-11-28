<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaisesTable extends Migration
{
    public function up()
    {
        Schema::create('paises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pais');
            $table->timestamps();
        });

        

    }

    public function down()
    {
        Schema::dropIfExists('paises');

    }
}
