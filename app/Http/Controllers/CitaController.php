<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CitaController extends Controller
{
    // Listado para FullCalendar
    public function index()
    {
        return view('partials.citas.index');
    }

    // JSON para FullCalendar
    public function data()
    {
        //$citas = Cita::select(
        //    'id',
        //    'inicio as start',
        //    'fin as end',
        //    'nota as title',
        //    'paciente_id'
        //)->get();

        $citas = Cita::with('paciente')->get()->map(function($cita) {
            return [
                'id' => $cita->id,
                'start' => $cita->inicio,
                'end' => $cita->fin,
                'inicio' => Carbon::parse($cita->inicio)->format('H:i'),
                //'title' => $cita->paciente->nombre,
                'title' => mb_convert_case(
                    "{$cita->paciente->apellido_paterno} {$cita->paciente->apellido_materno} {$cita->paciente->nombre}",
                    MB_CASE_TITLE,
                    "UTF-8"
                ),

            ];
        });
        return response()->json($citas);
    }

    public function create(Request $request)
    {
        $inicioISO = $request->query('inicio'); // Si quieres prellenar
        $finISO = $request->query('fin'); // Si quieres prellenar
        $inicio = $inicioISO ? \Carbon\Carbon::parse($inicioISO) : null;
        $fin = $finISO ? \Carbon\Carbon::parse($finISO) : null;
        $pacientes = Paciente::orderby('nombre')->get();
        return view('partials.citas.form', compact('inicio','fin', 'pacientes'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'inicio' => 'required|date',
            'fin' => 'required|date|after:inicio',
            'nota' => 'nullable|string|max:500',
        ]);

        Cita::create($validated);

        return response()->json([
            'ok' => true,
            'message' => 'Cita creada correctamente'
        ]);
    }

    public function confirmDelete(Cita $cita)
    {
        return view('partials.citas.confirm-delete', compact('cita'));
    }


    public function destroy(Cita $cita)
    {
        $cita->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Cita eliminada'
        ]);
    }

}

