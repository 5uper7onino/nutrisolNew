<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menus')->insert([
            [
                'nombre' => 'Desayuno ligero primavera',
                'descripcion' => 'Fruta fresca, yogurt y avena.',
                'comensales' => 4,
                'tipo_id' => 1, // Desayuno
                'temporada_id' => 1, // Primavera
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comida saludable de verano',
                'descripcion' => 'Pechuga asada, arroz integral y ensalada verde.',
                'comensales' => 5,
                'tipo_id' => 2, // Comida
                'temporada_id' => 2, // Verano
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Cena ligera de otoño',
                'descripcion' => 'Crema de calabaza y pan integral.',
                'comensales' => 3,
                'tipo_id' => 3, // Cena
                'temporada_id' => 3, // Otoño
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Desayuno escolar nutritivo',
                'descripcion' => 'Molletes con frijoles y fruta picada.',
                'comensales' => 10,
                'tipo_id' => 1, // Desayuno
                'temporada_id' => 5, // Escolar
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comida invernal reconfortante',
                'descripcion' => 'Caldo de pollo con verduras y arroz blanco.',
                'comensales' => 6,
                'tipo_id' => 2, // Comida
                'temporada_id' => 4, // Invierno
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Cena especial navideña',
                'descripcion' => 'Pavo al horno con puré y ensalada de manzana.',
                'comensales' => 12,
                'tipo_id' => 3, // Cena
                'temporada_id' => 6, // Festiva
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Colación vespertina saludable',
                'descripcion' => 'Barrita de cereal y jugo natural.',
                'comensales' => 15,
                'tipo_id' => 4, // Colación
                'temporada_id' => 2, // Verano
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Desayuno energético',
                'descripcion' => 'Huevos a la mexicana, plátano y café con leche.',
                'comensales' => 8,
                'tipo_id' => 1,
                'temporada_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comida tradicional mexicana',
                'descripcion' => 'Enchiladas verdes, arroz y agua de jamaica.',
                'comensales' => 9,
                'tipo_id' => 2,
                'temporada_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Cena escolar económica',
                'descripcion' => 'Sándwich integral con jamón y fruta.',
                'comensales' => 20,
                'tipo_id' => 3,
                'temporada_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
