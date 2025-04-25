<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('escola_lideres', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('nivel');
            $table->integer('carga_horaria');
            $table->string('material_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('certificado_template')->nullable();
            $table->json('pre_requisitos')->nullable();
            $table->timestamps();
        });

        Schema::create('modulos_escola_lideres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escola_id')->constrained('escola_lideres')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao');
            $table->integer('ordem');
            $table->integer('duracao_minutos');
            $table->string('material_url')->nullable();
            $table->string('video_url')->nullable();
            $table->json('questionario')->nullable();
            $table->timestamps();
        });

        Schema::create('escola_lideres_alunos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escola_id')->constrained('escola_lideres')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('progresso')->default(0);
            $table->boolean('concluido')->default(false);
            $table->timestamp('data_conclusao')->nullable();
            $table->decimal('nota', 4, 2)->nullable();
            $table->timestamps();

            $table->unique(['escola_id', 'user_id']);
        });

        Schema::create('progresso_modulo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modulo_id')->constrained('modulos_escola_lideres')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('concluido')->default(false);
            $table->timestamp('data_conclusao')->nullable();
            $table->decimal('nota_questionario', 4, 2)->nullable();
            $table->json('respostas_questionario')->nullable();
            $table->timestamps();

            $table->unique(['modulo_id', 'user_id']);
        });

        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('escola_lideres')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('codigo_verificacao')->unique();
            $table->timestamp('data_emissao');
            $table->string('arquivo_url');
            $table->timestamps();

            $table->unique(['curso_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificados');
        Schema::dropIfExists('progresso_modulo');
        Schema::dropIfExists('escola_lideres_alunos');
        Schema::dropIfExists('modulos_escola_lideres');
        Schema::dropIfExists('escola_lideres');
    }
}; 