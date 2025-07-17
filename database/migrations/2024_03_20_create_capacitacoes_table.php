<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('capacitacoes', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('titulo');
            $table->text('insights');
            $table->string('material_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capacitacoes');
    }
};