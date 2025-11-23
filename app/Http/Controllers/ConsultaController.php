<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\ConsultaFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Paciente;

class ConsultaController extends Controller
{
    /**
     * Listado de consultas de un paciente.
     */
    public function index($paciente_id)
    {
        $consultas = Consulta::where('paciente_id', $paciente_id)
            ->with('fotos')
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json($consultas);
    }

    public function create(Request $request)
    {
        $pacientes = Paciente::all();
        return view('partials.consultas.form', compact('pacientes'));
    }

    /**
     * Mostrar una consulta.
     */
    public function show($id)
    {
        $consulta = Consulta::with('fotos')->findOrFail($id);
        return response()->json($consulta);
    }

    /**
     * Crear una nueva consulta.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha'       => 'required|date',
            'peso'        => 'nullable|numeric',
            'altura'      => 'nullable|numeric',
            'cintura'     => 'nullable|numeric',
            'cadera'      => 'nullable|numeric',
            'cuello'      => 'nullable|numeric',
    
            // estos ya vendrán del formulario pero igual se recalculan aquí
            'imc'         => 'nullable|numeric',
            'icc'         => 'nullable|numeric',
            'igc'         => 'nullable|numeric',
    
            'descripcion' => 'nullable|string',
            'plan'        => 'nullable|string',
            'fotos.*'     => 'nullable|image|max:4096',
            'tipo_foto.*' => 'nullable|string'
        ]);
    
        /*
        |--------------------------------------------------------------------------
        | CÁLCULOS AUTOMÁTICOS
        |--------------------------------------------------------------------------
        */
    
        // IMC
        if (!empty($validated['peso']) && !empty($validated['altura'])) {
            $altura_m = $validated['altura'] / 100;
            $validated['imc'] = round($validated['peso'] / ($altura_m * $altura_m), 2);
        }
    
        // ICC = Cintura / Cadera
        if (!empty($validated['cintura']) && !empty($validated['cadera'])) {
            $validated['icc'] = round($validated['cintura'] / $validated['cadera'], 2);
        }
    
        // IGC (US Navy - mujeres sería distinto, si quieres lo ajusto)
        if (!empty($validated['cintura']) && !empty($validated['cuello']) && !empty($validated['altura'])) {
            $validated['igc'] = round(
                495 / (
                    1.0324
                    - 0.19077 * log10($validated['cintura'] - $validated['cuello'])
                    + 0.15456 * log10($validated['altura'])
                ) - 450,
                2
            );
        }
    
        /*
        |--------------------------------------------------------------------------
        | Crear la consulta
        |--------------------------------------------------------------------------
        */
        $consulta = Consulta::create($validated);
    
        /*
        |--------------------------------------------------------------------------
        | Manejo de fotos
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('fotos')) {
    
            foreach ($request->file('fotos') as $index => $foto) {
    
                $path = $foto->store('consultas', 'public');
    
                ConsultaFoto::create([
                    'consulta_id' => $consulta->id,
                    'tipo'        => $request->tipo_foto[$index] ?? 'sin_tipo',
                    'path'        => $path
                ]);
            }
        }
    
        return response()->json([
            'ok' => true,
            'message' => 'Consulta creada correctamente',
            'consulta' => $consulta->load('fotos')
        ]);
    }
    

    /**
     * Actualizar una consulta.
     */
    public function update(Request $request, $id)
    {
        $consulta = Consulta::findOrFail($id);

        $validated = $request->validate([
            'fecha'       => 'required|date',
            'peso'        => 'nullable|numeric',
            'altura'      => 'nullable|numeric',
            'imc'         => 'nullable|numeric',
            'descripcion' => 'nullable|string',
            'plan'        => 'nullable|string',
            'fotos.*'     => 'nullable|image|max:4096',
            'tipo_foto.*' => 'nullable|string'
        ]);

        $consulta->update($validated);

        // Añadir nuevas fotos si vienen
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $index => $foto) {

                $path = $foto->store('consultas', 'public');

                ConsultaFoto::create([
                    'consulta_id' => $consulta->id,
                    'tipo'        => $request->tipo_foto[$index] ?? 'sin_tipo',
                    'path'        => $path
                ]);
            }
        }

        return response()->json([
            'ok' => true,
            'message' => 'Consulta actualizada correctamente',
            'consulta' => $consulta->load('fotos')
        ]);
    }

    /**
     * Eliminar una consulta.
     */
    public function destroy($id)
    {
        $consulta = Consulta::findOrFail($id);

        // Borrar fotos del disco
        foreach ($consulta->fotos as $foto) {
            Storage::disk('public')->delete($foto->path);
            $foto->delete();
        }

        $consulta->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Consulta eliminada correctamente'
        ]);
    }

    /**
     * Eliminar una sola foto.
     */
    public function deleteFoto($id)
    {
        $foto = ConsultaFoto::findOrFail($id);

        Storage::disk('public')->delete($foto->path);

        $foto->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Foto eliminada'
        ]);
    }
}
