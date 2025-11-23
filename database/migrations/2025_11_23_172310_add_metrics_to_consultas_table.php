<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up():void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->decimal('icc', 5, 2)->nullable();   // Cintura / Cadera
            $table->decimal('igc', 5, 2)->nullable();   // Body Fat % (U.S. Navy)
            $table->decimal('cintura_cm', 5, 2)->nullable();
            $table->decimal('cadera_cm', 5, 2)->nullable();
            $table->decimal('cuello_cm', 5, 2)->nullable();
        });
    }
    
    public function down():void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn([
                'imc','icc','igc','cintura_cm','cadera_cm','cuello_cm'
            ]);
        });
    }
    
};
