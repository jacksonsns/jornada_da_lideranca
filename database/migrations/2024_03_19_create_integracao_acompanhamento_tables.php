<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('integracao_acompanhamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipo', ['mentoria', 'feedback', 'avaliacao']);
            $table->timestamp('data_encontro');
            $table->integer('duracao_minutos');
            $table->text('observacoes')->nullable();
            $table->json('metas_definidas')->nullable();
            $table->json('proximos_passos')->nullable();
            $table->enum('status', ['agendado', 'realizado', 'cancelado'])->default('agendado');
            $table->json('metricas_desempenho')->nullable();
            $table->timestamps();
        });

        Schema::create('avaliacoes_desempenho', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acompanhamento_id')->constrained('integracao_acompanhamento')->onDelete('cascade');
            $table->integer('nota_lideranca');
            $table->integer('nota_comunicacao');
            $table->integer('nota_trabalho_equipe');
            $table->integer('nota_proatividade');
            $table->integer('nota_comprometimento');
            $table->text('pontos_fortes')->nullable();
            $table->text('pontos_melhorar')->nullable();
            $table->text('recomendacoes')->nullable();
            $table->timestamps();
        });

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acompanhamento_id')->constrained('integracao_acompanhamento')->onDelete('cascade');
            $table->text('feedback');
            $table->enum('tipo_feedback', ['positivo', 'construtivo', 'geral']);
            $table->json('acoes_recomendadas')->nullable();
            $table->timestamp('prazo_implementacao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('avaliacoes_desempenho');
        Schema::dropIfExists('integracao_acompanhamento');
    }
}; 