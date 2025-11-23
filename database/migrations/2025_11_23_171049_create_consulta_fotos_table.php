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
        Schema::create('consulta_fotos', function (Blueprint $table) {
            $table->id();
    
            $table->unsignedBigInteger('consulta_id');
    
            // Tipo de foto: frente, lateral, espalda, cuerpo_completo
            $table->string('tipo', 50);
    
            // Ruta del archivo
            $table->string('path');
    
            $table->timestamps();
    
            // Relación
            $table->foreign('consulta_id')
                  ->references('id')->on('consultas')
                  ->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consulta_fotos');
    }
};
