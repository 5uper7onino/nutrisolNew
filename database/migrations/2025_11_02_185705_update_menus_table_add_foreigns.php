<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->foreign('tipo_id')
                  ->references('id')
                  ->on('tipos_menu')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('temporada_id')
                  ->references('id')
                  ->on('temporadas')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['tipo_id']);
            $table->dropForeign(['temporada_id']);
        });
    }
};
