<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('avaliacao_aulas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aula_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('avaliacao');
            $table->text('comentario')->nullable();
            $table->timestamps();

            $table->unique(['aula_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('avaliacao_aulas');
    }
}; 