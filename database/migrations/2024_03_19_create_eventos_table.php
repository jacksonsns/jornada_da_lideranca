<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->timestamp('data_inicio');
            $table->timestamp('data_fim')->nullable();
            $table->string('local')->nullable();
            $table->string('google_calendar_id')->nullable();
            $table->foreignId('criador_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('evento_participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('confirmado')->default(false);
            $table->timestamp('data_confirmacao')->nullable();
            $table->timestamps();

            $table->unique(['evento_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('evento_participantes');
        Schema::dropIfExists('eventos');
    }
}; 