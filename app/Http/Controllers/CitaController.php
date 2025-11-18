<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

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
        $citas = Cita::select(
            'id',
            'inicio as start',
            'fin as end',
            'nota as title'
        )->get();

        return response()->json($citas);
    }

    public function create(Request $request)
    {
        $fecha = $request->query('fecha'); // Si quieres prellenar
        return view('citas.create', compact('fecha'));
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

