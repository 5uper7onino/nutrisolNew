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
        Schema::table('pacientes', function (Blueprint $table) {

            // Hábitos
            $table->boolean('fuma')->default(false)->after('estado_civil_id');
            $table->date('fumador_desde')->nullable()->after('fuma');
            $table->string('fumador_cantidad')->nullable()->after('fumador_desde');
        
            $table->boolean('toma')->default(false)->after('fumador_cantidad');
            $table->string('toma_frecuencia')->nullable()->after('toma');
        
            $table->boolean('hace_ejercicio')->default(false)->after('toma_frecuencia');
            $table->string('tipo_ejercicio')->nullable()->after('hace_ejercicio');
        
            // Antecedentes
            $table->boolean('tuvo_covid')->default(false)->after('tipo_ejercicio');
            $table->date('covid_fecha')->nullable()->after('tuvo_covid');
        
            $table->boolean('fracturas')->default(false)->after('covid_fecha');
            $table->text('detalle_fracturas')->nullable()->after('fracturas');
        
            $table->text('medicamentos_actuales')->nullable()->after('detalle_fracturas');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            //
        });
    }
};
