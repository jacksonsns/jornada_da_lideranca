<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jornada_aspirante_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jornada_aspirante_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('progresso')->default(0);
            $table->boolean('concluido')->default(false);
            $table->timestamps();

            $table->unique(['jornada_aspirante_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('jornada_aspirante_user');
    }
}; 