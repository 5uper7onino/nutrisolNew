<?php

namespace Database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemporadasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('temporadas')->insert([
            ['nombre' => 'Primavera', 'descripcion' => 'Temporada de primavera', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Verano', 'descripcion' => 'Temporada de verano', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Otoño', 'descripcion' => 'Temporada de otoño', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Invierno', 'descripcion' => 'Temporada de invierno', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Escolar', 'descripcion' => 'Ciclo escolar activo', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Festiva', 'descripcion' => 'Temporadas especiales o festivas', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
