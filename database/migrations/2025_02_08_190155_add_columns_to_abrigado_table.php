<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('abrigado', function (Blueprint $table) {
            $table->date('data_entrada')->nullable();
            $table->date('data_saida')->nullable();
            $table->string('cidade_origem', 255)->nullable();
            $table->string('telefone', 255)->nullable();
            $table->string('itemPrioridade', 255)->nullable();


        });
    }

    public function down()
    {
        Schema::table('abrigado', function (Blueprint $table) {
            $table->dropColumn(['data_entrada', 'data_saida', 'cidade_origem', 'telefone', 'itemPrioridade']);
        });
    }
};

