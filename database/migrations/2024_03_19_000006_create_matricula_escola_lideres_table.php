<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('matricula_escola_lideres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('modulo_escola_lideres_id')->constrained()->onDelete('cascade');
            $table->datetime('data_inicio');
            $table->datetime('data_conclusao')->nullable();
            $table->string('status')->default('em_andamento');
            $table->timestamps();

            $table->unique(['user_id', 'modulo_escola_lideres_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('matricula_escola_lideres');
    }
}; 