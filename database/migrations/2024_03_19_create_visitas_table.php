<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('secao');
            $table->timestamps();

            // Garante que não haverá duplicatas de visitas na mesma seção
            $table->unique(['user_id', 'secao']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitas');
    }
}; 