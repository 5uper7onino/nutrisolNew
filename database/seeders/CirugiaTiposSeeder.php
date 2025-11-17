<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CirugiaTiposSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            'Apendicectomía',
            'Colecistectomía',
            'Cesárea',
            'Hernia inguinal',
            'Hernia umbilical',
            'Amigdalectomía',
            'Cirugía bariátrica',
            'Cirugía de tiroides',
            'Cirugía ortopédica',
            'Cirugía de rodilla',
            'Cirugía de cadera',
            'Cirugía cardíaca',
            'Cirugía de columna',
            'Cirugía ocular (oftalmológica)',
            'Cirugía ginecológica',
            'Histerectomía',
            'Prostatectomía',
            'Laparoscopía diagnóstica',
            'Cirugía oncológica',
            'Cirugía maxilofacial',
            'Vesícula biliar',
            'Litiasis renal',
            'Bypass gástrico',
            'Otros'
        ];

        foreach ($tipos as $t) {
            DB::table('cirugia_tipos')->insert([
                'nombre' => $t,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
