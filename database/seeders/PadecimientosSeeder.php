<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Padecimiento;

class PadecimientosSeeder extends Seeder
{
    public function run()
    {
        $padecimientos = [
            'Obesidad',
            'Sobrepeso',
            'Diabetes tipo 2',
            'Hipertensión arterial',
            'Dislipidemia (colesterol / triglicéridos altos)',
            'Resistencia a la insulina',
            'Hígado graso no alcohólico',
            'Síndrome metabólico',
            'Anemia por deficiencia de hierro',
            'Gastritis',
            'Reflujo gastroesofágico (GERD)',
            'Estreñimiento crónico',
            'Colitis / Síndrome de intestino irritable (IBS)',
            'Intolerancia a la lactosa',
            'Intolerancia al gluten (sensibilidad)',
            'Enfermedad celíaca',
            'Hipotiroidismo',
            'Enfermedad renal crónica (etapas iniciales)',
            'Desnutrición',
            'Trastorno por atracón (Binge Eating)',
        ];

        foreach ($padecimientos as $nombre) {
            Padecimiento::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
