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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
    
            // Fecha de la consulta
            $table->dateTime('fecha');
    
            // Datos clínicos
            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('altura', 5, 2)->nullable();
            $table->decimal('imc', 5, 2)->nullable();
    
            // Síntomas, hallazgos, notas del doctor
            $table->text('descripcion')->nullable();
    
            // Tratamiento o plan indicado
            $table->text('plan')->nullable();
    
            $table->timestamps();
    
            // Relación
            $table->foreign('paciente_id')
                  ->references('id')->on('pacientes')
                  ->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
