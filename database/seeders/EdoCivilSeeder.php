<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EdoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('edo_civil')->insert([
            ['nombre' => 'Soltero(a)'],
            ['nombre' => 'Casado(a)'],
            ['nombre' => 'Unión libre'],
            ['nombre' => 'Divorciado(a)'],
            ['nombre' => 'Viudo(a)'],
        ]);
    }
}
