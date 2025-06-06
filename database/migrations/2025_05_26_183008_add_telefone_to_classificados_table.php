<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('classificados', function (Blueprint $table) {
            $table->string('telefone')->nullable()->after('bairro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classificados', function (Blueprint $table) {
            $table->dropColumn('telefone');
        });
    }
};
