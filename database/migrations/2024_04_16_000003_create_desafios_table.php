<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('desafios', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('nivel')->default('0');
            $table->string('tipo');
            $table->integer('pontos');
            // $table->date('data_inicio');
            // $table->date('data_fim');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('desafio_user');
        Schema::dropIfExists('desafios');
    }
}; 