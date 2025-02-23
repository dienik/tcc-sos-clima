<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemsTable extends Migration
{
    public function up()
    {
        Schema::create('tem', function (Blueprint $table) {
            $table->foreignId('fk_prioridades')->references('pk_prioridade')->on('prioridades')->onDelete('cascade');
            $table->foreignId('fk_abrigo')->references('pk_abrigo')->on('abrigo')->onDelete('cascade');
            $table->boolean('precisando');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tem');
    }
}
