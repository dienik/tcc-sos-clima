<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoacoesTable extends Migration
{
    public function up()
    {
        Schema::create('doacao', function (Blueprint $table) {
            $table->id('pk_doacao');
            $table->date('recebimento');
            // Ajuste na criação da chave estrangeira
            $table->unsignedBigInteger('fk_doador'); // Definindo tipo correto para chave estrangeira
            $table->unsignedBigInteger('fk_coletor'); // Também definindo para coletor

            // Criando as restrições de chave estrangeira
            $table->foreign('fk_doador')->references('pk_doador')->on('doador')->onDelete('cascade');
            $table->foreign('fk_coletor')->references('pk_coletor')->on('coletor')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doacao');
    }
}
