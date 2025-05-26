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
        Schema::create('classificados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao');
            $table->decimal('preco', 10, 2);
            $table->string('categoria');
            $table->string('estado');
            $table->string('cidade');
            $table->string('bairro')->nullable();
            $table->json('imagens')->nullable();
            $table->boolean('destaque')->default(false);
            $table->boolean('ativo')->default(true);
            $table->integer('visualizacoes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classificados');
    }
};
