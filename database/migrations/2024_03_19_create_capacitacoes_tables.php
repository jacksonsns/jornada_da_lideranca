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
            $table->timestamp('data_realizacao');
            $table->string('instrutor');
            $table->string('material_url')->nullable();
            $table->json('insights')->nullable();
            $table->string('categoria');
            $table->integer('carga_horaria');
            $table->string('local');
            $table->timestamps();
        });

        Schema::create('capacitacao_participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capacitacao_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('presente')->default(false);
            $table->text('feedback')->nullable();
            $table->decimal('nota', 4, 2)->nullable();
            $table->timestamps();

            $table->unique(['capacitacao_id', 'user_id']);
        });

        Schema::create('capacitacao_anexos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capacitacao_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->string('arquivo_url');
            $table->string('tipo');
            $table->timestamps();
        });

        Schema::create('capacitacao_avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capacitacao_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('nota_conteudo');
            $table->integer('nota_instrutor');
            $table->integer('nota_material');
            $table->integer('nota_organizacao');
            $table->text('pontos_positivos')->nullable();
            $table->text('pontos_melhorias')->nullable();
            $table->text('sugestoes')->nullable();
            $table->timestamps();

            $table->unique(['capacitacao_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('capacitacao_avaliacoes');
        Schema::dropIfExists('capacitacao_anexos');
        Schema::dropIfExists('capacitacao_participantes');
        Schema::dropIfExists('capacitacoes');
    }
}; 