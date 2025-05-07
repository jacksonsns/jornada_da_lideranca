<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscolaLideresTable extends Migration
{
    public function up()
    {
        Schema::create('escola_lideres', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escola_lideres');
    }
}
