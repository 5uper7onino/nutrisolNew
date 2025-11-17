<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OcupacionesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ocupaciones')->insert([
            ['nombre' => 'Empleado', 'activo' => true],
            ['nombre' => 'Estudiante', 'activo' => true],
            ['nombre' => 'Ama de casa', 'activo' => true],
            ['nombre' => 'Jubilado', 'activo' => true],
            ['nombre' => 'Desempleado', 'activo' => true],
            ['nombre' => 'Independiente', 'activo' => true],
        ]);
    }
}
