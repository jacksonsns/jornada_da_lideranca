<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('classificados', function (Blueprint $table) {
            $table->string('beneficio')->nullable()->after('telefone');
            $table->string('site')->nullable()->after('beneficio');
            $table->string('instagram')->nullable()->after('site');
            $table->string('facebook')->nullable()->after('instagram');
        });
    }

    public function down()
    {
        Schema::table('classificados', function (Blueprint $table) {
            $table->dropColumn(['beneficio', 'site', 'instagram', 'facebook']);
        });
    }
}; 