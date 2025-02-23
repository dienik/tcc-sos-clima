<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('abrigo', function (Blueprint $table) {
            $table->integer('capacidade_maxima')->default(100); // Valor padrão 100
        });
    }

    public function down()
    {
        Schema::table('abrigo', function (Blueprint $table) {
            $table->dropColumn('capacidade_maxima');
        });
    }
};
