<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('admin');
            $table->date('data_nascimento')->nullable()->comment('Data de Nascimento');
            $table->text('cargo')->nullable()->comment('Cargos Ocupados');
            $table->text('eventos')->nullable()->comment('Eventos Participados');
            $table->text('comissoes')->nullable()->comment('Comissões de Projetos');
            $table->text('concursos_participados')->nullable()->comment('Concursos Participados');
            $table->text('premiacoes')->nullable()->comment('Premiações e Realizações');
            $table->text('empresas_vinculos')->nullable()->comment('Empresas com Vínculos');
            $table->text('curso_facilitador')->nullable()->comment('Cursos como Facilitador');
            $table->boolean('impact')->default(false)->nullable();
            $table->boolean('archieve')->default(false)->nullable();
            $table->boolean('responsabilidade')->default(false)->nullable();
            $table->boolean('reunioes')->default(false)->nullable();
            $table->boolean('networking')->default(false)->nullable();
            $table->boolean('mentoring')->default(false)->nullable();
            $table->boolean('explore')->default(false)->nullable();
            $table->boolean('envolva')->default(false)->nullable();
            $table->boolean('contruindo_fundacao')->default(false)->nullable();
            $table->boolean('elaborando_mensagem')->default(false)->nullable();
            $table->boolean('entrega_mensagem')->default(false)->nullable();
            $table->boolean('gestao_marketing')->default(false)->nullable();
            $table->boolean('lideranca')->default(false)->nullable();
            $table->boolean('facilitador')->default(false)->nullable();
            $table->boolean('gerenciamento_projeto')->default(false)->nullable();
            $table->boolean('discover')->default(false)->nullable();
            $table->boolean('apresentador')->default(false)->nullable();
            $table->boolean('oratoria')->default(false)->nullable();
            $table->string('outro')->nullable()->comment('Outros Cursos');
        });
    }
}; 