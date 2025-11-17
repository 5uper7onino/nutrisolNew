<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hospitalizaciones', function (Blueprint $table) {
            $table->id();
    
            // Relación con paciente
            $table->foreignId('paciente_id')
                  ->constrained('pacientes')
                  ->onDelete('cascade');
    
            // Datos de hospitalización
            $table->string('motivo')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_alta')->nullable();
            $table->string('hospital')->nullable();
            $table->text('notas')->nullable();
    
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('hospitalizaciones');
    }

};
