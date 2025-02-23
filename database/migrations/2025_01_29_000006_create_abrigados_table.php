<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbrigadosTable extends Migration
{
    public function up()
    {
        Schema::create('abrigado', function (Blueprint $table) {
            $table->id('pk_abrigado');
            $table->foreignId('fk_abrigo')->references('pk_abrigo')->on('abrigo')->onDelete('cascade');;
            $table->string('nome', 50);
            $table->string('sobrenome', 100);
            $table->string('informacoes', 250);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('abrigado');
    }
}
