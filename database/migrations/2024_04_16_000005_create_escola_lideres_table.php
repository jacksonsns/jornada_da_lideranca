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
            $table->integer('duracao_minutos');
            $table->string('link_video')->nullable();
            $table->string('link_material')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        Schema::create('escola_lideres_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('escola_lideres_id')->constrained()->onDelete('cascade');
            $table->boolean('concluido')->default(false);
            $table->date('data_conclusao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escola_lideres_user');
        Schema::dropIfExists('escola_lideres');
    }
}; 