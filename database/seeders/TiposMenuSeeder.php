<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposMenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos_menu')->insert([
            ['nombre' => 'Desayuno', 'descripcion' => 'Menús matutinos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Comida', 'descripcion' => 'Menús de medio día', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cena', 'descripcion' => 'Menús nocturnos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Colación', 'descripcion' => 'Pequeñas porciones o refrigerios', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Especial', 'descripcion' => 'Menús para ocasiones especiales', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
