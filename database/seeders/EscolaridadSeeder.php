<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscolaridadSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('escolaridad')->insert([
            ['nombre' => 'Sin estudios', 'activo' => true],
            ['nombre' => 'Primaria', 'activo' => true],
            ['nombre' => 'Secundaria', 'activo' => true],
            ['nombre' => 'Preparatoria / Bachillerato', 'activo' => true],
            ['nombre' => 'Técnico / Comercial', 'activo' => true],
            ['nombre' => 'Universidad / Licenciatura', 'activo' => true],
            ['nombre' => 'Maestría', 'activo' => true],
            ['nombre' => 'Doctorado', 'activo' => true],
        ]);
    }
}
