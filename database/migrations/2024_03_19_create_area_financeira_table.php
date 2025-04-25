<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('area_financeira', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->nullable()->constrained('projetos_individuais')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['receita', 'despesa']);
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
            $table->timestamp('data_lancamento');
            $table->string('categoria');
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])->default('pendente');
            $table->string('comprovante')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('area_financeira');
    }
}; 