<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        $this->call([
            TiposMenuSeeder::class,
            TemporadasSeeder::class,
            MenusSeeder::class,
            SucursalesSeeder::class,
            ProductosSeeder::class,
            EdoCivilSeeder::class,
            OcupacionesSeeder::class,
            EscolaridadSeeder::class,
            PadecimientosSeeder::class,
            CirugiaTiposSeeder::class,
        ]);

                User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Isis Marisol Montañez Cerda',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'sucursal_id' => 1,
                'email_verified_at' => now(),
                'profile_photo_path' => 'storage/users/1/soli.jpg',
            ]
        );
    }
}
