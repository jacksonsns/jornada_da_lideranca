<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tevep_acoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tevep_id')->constrained('teveps')->onDelete('cascade');
            $table->date('prazo')->nullable();
            $table->string('evento_acao')->nullable();
            $table->string('espaco')->nullable();
            $table->string('pessoas')->nullable();
            $table->string('piloto')->nullable();
            $table->string('recursos')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tevep_acoes');
    }
};
