<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColetoresTable extends Migration
{
    public function up()
    {
        Schema::create('coletor', function (Blueprint $table) {
            $table->id('pk_coletor');
            $table->string('nome', 50);
            $table->string('sobrenome', 100);
            $table->string('email', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coletor');
    }
}
