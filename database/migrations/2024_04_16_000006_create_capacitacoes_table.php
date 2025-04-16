<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('capacitacoes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('tipo');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('link_material')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        Schema::create('capacitacao_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('capacitacao_id')->constrained('capacitacoes')->onDelete('cascade');
            $table->boolean('concluido')->default(false);
            $table->date('data_conclusao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('capacitacao_user');
        Schema::dropIfExists('capacitacoes');
    }
}; 