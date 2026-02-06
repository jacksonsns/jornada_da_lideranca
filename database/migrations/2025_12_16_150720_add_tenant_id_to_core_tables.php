<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'agenda',
            'area_financeira',
            'classificados',
            'eventos',
            'integracao_acompanhamento',
            'projetos',
            'quadro_dos_sonhos',
            'transacoes',
            'visitas',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete()->after('id');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'agenda',
            'area_financeira',
            'classificados',
            'eventos',
            'integracao_acompanhamento',
            'projetos',
            'quadro_dos_sonhos',
            'transacoes',
            'visitas',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('tenant_id');
            });
        }
    }
};
