<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItensTable extends Migration
{
    public function up()
    {
        Schema::create('itens', function (Blueprint $table) {
            $table->id('pk_itens');
            // Alteração: Especificando explicitamente a chave primária de 'doacao'
            $table->unsignedBigInteger('fk_doacao');
            $table->foreign('fk_doacao')->references('pk_doacao')->on('doacao')->onDelete('cascade');
            $table->string('descricao', 100);
            $table->decimal('quantidade', 10, 2);
            $table->date('validade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itens');
    }
}
