<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conquistas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao');
            $table->integer('pontos');
            $table->string('criterio');
            $table->integer('valor_requerido');
            $table->timestamps();
        });

        Schema::create('conquista_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conquista_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('conquistado_em')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'conquista_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('conquista_user');
        Schema::dropIfExists('conquistas');
    }
}; 