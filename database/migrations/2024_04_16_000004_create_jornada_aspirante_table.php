<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jornada_aspirante', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->integer('ordem');
            $table->boolean('obrigatorio')->default(true);
            $table->timestamps();
        });

        Schema::create('jornada_aspirante_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jornada_aspirante_id')->constrained('jornada_aspirante')->onDelete('cascade');
            $table->boolean('concluido')->default(false);
            $table->date('data_conclusao')->nullable();
            $table->integer('progresso')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jornada_aspirante_user');
        Schema::dropIfExists('jornada_aspirante');
    }
}; 