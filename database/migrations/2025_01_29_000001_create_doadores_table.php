<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoadoresTable extends Migration
{
    public function up()
    {
        Schema::create('doador', function (Blueprint $table) {
            $table->id('pk_doador');
            $table->string('nome', 50);
            $table->string('sobrenome', 100);
            $table->string('email', 100);
            $table->string('telefone', 30);
            $table->string('cnpj', 30)->nullable();
            $table->string('cpf', 30)->nullable();
            $table->string('endereco', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doador');
    }
}
