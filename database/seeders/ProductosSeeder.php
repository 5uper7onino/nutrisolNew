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
            ['nombre' => 'Arroz 1kg', 'tipo' => 'peso','coste'=>1.00],
            ['nombre' => 'Refresco 2L', 'tipo' => 'botella','coste'=>1.00],
            ['nombre' => 'Cereal caja grande', 'tipo' => 'caja','coste'=>1.00],
            ['nombre' => 'Frijoles en lata', 'tipo' => 'lata','coste'=>1.00],
            ['nombre' => 'Pan dulce paquete', 'tipo' => 'paquete','coste'=>1.00],
            ['nombre' => 'Aceite vegetal 1L', 'tipo' => 'botella','coste'=>1.00],
            ['nombre' => 'Galletas surtidas', 'tipo' => 'paquete','coste'=>1.00],
            ['nombre' => 'Salsa picante frasco', 'tipo' => 'frasco','coste'=>1.00],
            ['nombre' => 'Arándanos bolsa', 'tipo' => 'bolsa','coste'=>1.00],
            ['nombre' => 'Servilletas 100 pzas', 'tipo' => 'paquete','coste'=>1.00],
        ];

        foreach ($productos as $producto) {
            $tipoId = DB::table('tipos_producto')
                ->where('nombre', $producto['tipo'])
                ->value('id');

            DB::table('productos')->insert([
                'nombre' => $producto['nombre'],
                'tipo_id' => $tipoId,
                'coste' => $producto['coste'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
