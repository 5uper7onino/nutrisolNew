<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cita;
use Carbon\Carbon;

class CitasSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth   = $now->copy()->endOfMonth();

        for ($i = 0; $i < 10; $i++) {

            // Día aleatorio del mes actual
            $startDay = Carbon::create(
                $now->year,
                $now->month,
                rand(1, $endOfMonth->day),
                rand(8, 17),              // hora entre 8 AM y 5 PM
                rand(0, 1) ? 0 : 30       // minutos 00 o 30
            );

            // Duración fija: 1 hora
            $endDay = $startDay->copy()->addHour();

            Cita::create([
                'paciente_id' => 1, // Asumiendo que hay al menos 10 pacientes
                'inicio' => $startDay,
                'fin'    => $endDay,
                'nota'   => 'Cita de prueba #' . ($i + 1),
            ]);
        }
    }
}
