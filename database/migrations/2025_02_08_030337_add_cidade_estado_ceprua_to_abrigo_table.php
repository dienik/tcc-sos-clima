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
            $table->renameColumn('endereco', 'rua');
            $table->string('numero')->after('rua');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abrigo', function (Blueprint $table) {
            $table->renameColumn('rua', 'endereco');
        });
    }
};
