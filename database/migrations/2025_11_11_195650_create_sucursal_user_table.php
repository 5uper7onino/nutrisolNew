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
        // database/migrations/xxxx_create_sucursal_user_table.php
        Schema::create('sucursal_user', function (Blueprint $table) {
            $table->unsignedBigInteger('sucursal_id');
            $table->unsignedBigInteger('user_id');
            $table->primary(['sucursal_id', 'user_id']);
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursal_user');
    }
};
