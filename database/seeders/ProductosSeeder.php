<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        // Insertar tipos de producto
        $tipos = [
            'peso',
            'paquete',
            'caja',
            'tamaño',
            'pieza',
            'botella',
            'lata',
            'bolsa',
            'frasco',
            'otro',
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipos_producto')->insert([
                'nombre' => $tipo,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Insertar productos (10 ejemplos)
        $productos = [
            ['nombre' => 'Arroz 1kg', 'tipo' => 'peso'],
            ['nombre' => 'Refresco 2L', 'tipo' => 'botella'],
            ['nombre' => 'Cereal caja grande', 'tipo' => 'caja'],
            ['nombre' => 'Frijoles en lata', 'tipo' => 'lata'],
            ['nombre' => 'Pan dulce paquete', 'tipo' => 'paquete'],
            ['nombre' => 'Aceite vegetal 1L', 'tipo' => 'botella'],
            ['nombre' => 'Galletas surtidas', 'tipo' => 'paquete'],
            ['nombre' => 'Salsa picante frasco', 'tipo' => 'frasco'],
            ['nombre' => 'Arándanos bolsa', 'tipo' => 'bolsa'],
            ['nombre' => 'Servilletas 100 pzas', 'tipo' => 'paquete'],
        ];

        foreach ($productos as $producto) {
            $tipoId = DB::table('tipos_producto')
                ->where('nombre', $producto['tipo'])
                ->value('id');

            DB::table('productos')->insert([
                'nombre' => $producto['nombre'],
                'tipo_id' => $tipoId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
