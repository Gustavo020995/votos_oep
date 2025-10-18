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
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesa_id')->constrained()->onDelete('cascade');
            $table->foreignId('candidato_id')->constrained()->onDelete('cascade');
            $table->integer('votos')->default(0);
            $table->string('foto_acta')->nullable();
            $table->string('numero_acta')->nullable();
            $table->timestamp('fecha_acta')->nullable();
            $table->enum('estado_acta', ['pendiente', 'aprobada', 'rechazada', 'observada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->unique(['mesa_id', 'candidato_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
