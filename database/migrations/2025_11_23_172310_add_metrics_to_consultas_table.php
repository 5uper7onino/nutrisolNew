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

            $table->decimal('cintura', 5, 2)->nullable()->after('altura');
            $table->decimal('cadera', 5, 2)->nullable()->after('cintura');
            $table->decimal('cuello', 5, 2)->nullable()->after('cadera');
            $table->decimal('icc', 5, 2)->nullable()->after('imc');   // Cintura / Cadera
            $table->decimal('igc', 5, 2)->nullable()->after('icc');   // Body Fat % (U.S. Navy)
        });
    }
    
    public function down():void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn([
                'imc','icc','igc','cintura','cadera','cuello'
            ]);
        });
    }
    
};
