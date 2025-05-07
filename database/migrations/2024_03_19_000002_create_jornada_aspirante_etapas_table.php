<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jornada_aspirante_etapas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jornada_aspirante_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao');
            $table->integer('pontos');
            $table->integer('ordem');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jornada_aspirante_etapas');
    }
}; 