<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recintos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('localidad_id')->references('id')->on('localidades')->onDelete('cascade');
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->string('direccion')->nullable();
            $table->integer('total_inscritos')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recintos');
    }
};