<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('abrigo', function (Blueprint $table) {
            $table->string('cidade')->after('endereco');
            $table->string('estado', 2)->after('cidade');
            $table->string('cep', 9)->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abrigo', function (Blueprint $table) {
            $table->dropColumn(['cidade', 'estado', 'cep']);
        });
    }
};
