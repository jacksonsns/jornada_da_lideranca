<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modulo_escola_lideres_id')->constrained('modulo_escola_lideres')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->longText('conteudo');
            $table->string('video_url')->nullable();
            $table->string('material_url')->nullable();
            $table->integer('duracao_minutos');
            $table->integer('ordem');
            $table->timestamps();
        });

        Schema::create('aula_matricula', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aula_id')->constrained()->onDelete('cascade');
            $table->foreignId('matricula_escola_lideres_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['aula_id', 'matricula_escola_lideres_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('aula_matricula');
        Schema::dropIfExists('aulas');
    }
}; 