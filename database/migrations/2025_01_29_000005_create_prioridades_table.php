<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrioridadesTable extends Migration
{
    public function up()
    {
        Schema::create('prioridades', function (Blueprint $table) {
            $table->id('pk_prioridade');
            $table->string('descricao', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prioridades');
    }
}
