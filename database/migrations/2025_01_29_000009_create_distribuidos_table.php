<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistribuidosTable extends Migration
{
    public function up()
    {
        Schema::create('distribuido', function (Blueprint $table) {
            $table->foreignId('fk_itens')->references('pk_itens')->on('itens')->onDelete('cascade');
            $table->foreignId('fk_abrigo')->references('pk_abrigo')->on('abrigo')->onDelete('cascade');
            $table->decimal('quantidade', 10, 2);
            $table->date('data');
            $table->string('observacao', 100)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('distribuido');
    }
}
