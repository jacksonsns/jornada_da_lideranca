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
        Schema::create('modulos_escola_lideres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escola_id')->constrained('escola_lideres')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->integer('ordem')->default(0);
            $table->integer('duracao_minutos')->nullable();
            $table->string('material_url')->nullable();
            $table->string('video_url')->nullable();
            $table->json('questionario')->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos_escola_lideres');
    }
};
