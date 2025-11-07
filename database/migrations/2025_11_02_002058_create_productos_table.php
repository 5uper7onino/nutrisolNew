<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unidades_medida', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');       // Ej: "Kilogramo"
            $table->string('abreviacion');  // Ej: "kg"
            $table->timestamps();
        });


        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('tipo_id')->constrained('tipos_producto')->onDelete('cascade');
            $table->foreignId('unidad_medida_id')->constrained('unidades_medida');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
        Schema::dropIfExists('unidades_medida');
    }
};
