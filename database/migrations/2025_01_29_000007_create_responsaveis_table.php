<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsaveisTable extends Migration
{
    public function up()
    {
        Schema::create('responsaveis', function (Blueprint $table) {
            $table->id('pk_responsavel');
            $table->string('atribuição', 30);
            $table->foreignId('fk_abrigo')->references('pk_abrigo')->on('abrigo')->onDelete('cascade');
            $table->string('nome', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('responsaveis');
    }
}
