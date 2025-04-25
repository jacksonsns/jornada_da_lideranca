<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao');
            $table->text('objetivo');
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
            $table->enum('status', ['planejamento', 'em_andamento', 'concluido', 'suspenso'])->default('planejamento');
            $table->integer('progresso')->default(0);
            $table->text('metas_5_anos');
            $table->text('indicadores_sucesso');
            $table->text('recursos_necessarios');
            $table->timestamps();
        });

        Schema::create('projeto_mentores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->constrained()->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('metas_projeto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->constrained()->onDelete('cascade');
            $table->text('descricao');
            $table->dateTime('prazo');
            $table->enum('status', ['pendente', 'em_andamento', 'concluida'])->default('pendente');
            $table->timestamps();
        });

        Schema::create('atualizacoes_projeto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->constrained()->onDelete('cascade');
            $table->text('descricao');
            $table->integer('progresso');
            $table->text('dificuldades')->nullable();
            $table->text('solucoes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atualizacoes_projeto');
        Schema::dropIfExists('metas_projeto');
        Schema::dropIfExists('projeto_mentores');
        Schema::dropIfExists('projetos');
    }
}; 