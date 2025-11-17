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
        Schema::create('paciente_padecimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('padecimiento_id');
            $table->unsignedBigInteger('paciente_id');
    
            $table->foreign('padecimiento_id')->references('id')->on('padecimientos')->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('padecimiento_paciente');
    }
};
