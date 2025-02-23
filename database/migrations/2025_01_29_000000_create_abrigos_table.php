<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbrigosTable extends Migration
{
    public function up()
    {
        Schema::create('abrigo', function (Blueprint $table) {
            $table->id('pk_abrigo');
            $table->string('nome', 100);
            $table->string('endereco', 100);
            $table->string('telefone', 30);
            $table->string('cnpj', 30);
            $table->string('email', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('abrigo');
    }
}
