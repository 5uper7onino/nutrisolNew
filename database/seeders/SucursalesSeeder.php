<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sucursal;

class SucursalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sucursales = [
            [
                'nombre' => 'Sucursal Huiramba',
                'direccion' => 'Av. Principal #123, Col. Centro',
                'telefono' => '555-123-4567',
            ],
            [
                'nombre' => 'Sucursal Zapopan',
                'direccion' => 'Calle del Bosque #45, Col. Industrial',
                'telefono' => '555-987-6543',
            ],

        ];

        foreach ($sucursales as $sucursal) {
            Sucursal::create($sucursal);
        }
    }
}
