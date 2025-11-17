<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cirugias', function (Blueprint $table) {
            $table->id();
    
            $table->foreignId('paciente_id')
                  ->constrained('pacientes')
                  ->onDelete('cascade');
    
            $table->foreignId('cirugia_tipo_id')
                  ->nullable()
                  ->constrained('cirugia_tipos');
    
            $table->string('cirugia_otro')->nullable(); // si eligen “Otro”
    
            $table->date('fecha')->nullable();
            $table->string('notas')->nullable();
    
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('cirugias');
    }
};
