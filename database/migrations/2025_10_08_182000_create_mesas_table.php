<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mesas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recinto_id')->constrained()->onDelete('cascade');
            $table->string('numero_mesa');
            $table->string('codigo_mesa')->unique();
            $table->integer('total_inscritos')->default(0);
            $table->enum('estado', ['pendiente', 'conteo_en_proceso', 'conteo_finalizado'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mesas');
    }
};