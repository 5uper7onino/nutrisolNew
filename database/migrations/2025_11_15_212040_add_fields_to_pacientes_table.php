<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->date('fecha_inicio')->nullable()->after('fecha_nacimiento');
            $table->unsignedBigInteger('ocupacion_id')->nullable()->after('curp');
            $table->unsignedBigInteger('escolaridad_id')->nullable()->after('ocupacion_id');
            $table->unsignedBigInteger('estado_civil_id')->nullable()->after('escolaridad_id');
            $table->unsignedBigInteger('sucursal_id')->nullable()->after('estado_civil_id');

            $table->foreign('ocupacion_id')->references('id')->on('ocupaciones')->nullOnDelete();
            $table->foreign('escolaridad_id')->references('id')->on('escolaridad')->nullOnDelete();
            $table->foreign('estado_civil_id')->references('id')->on('edo_civil')->nullOnDelete();
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropForeign(['ocupacion_id']);
            $table->dropForeign(['escolaridad_id']);
            $table->dropForeign(['estado_civil_id']);

            $table->dropColumn([
                'ocupacion_id',
                'escolaridad_id',
                'estado_civil_id',
                'sucursal_id',
                'fecha_inicio'
            ]);
        });
    }
};
