<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::create('votos_especiales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesa_id')->constrained()->onDelete('cascade');
            $table->foreignId('tipo_voto_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad')->default(0);
            $table->timestamps();
            
            $table->unique(['mesa_id', 'tipo_voto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votos_especiales');
    }
};
