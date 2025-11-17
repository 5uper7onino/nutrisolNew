<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Paciente;
use App\Models\EdoCivil;
use App\Models\Ocupacion;
use App\Models\Escolaridad;
use App\Models\Padecimiento;
use App\Models\CirugiaTipo;

class PacienteController extends Controller
{
    /**
     * Muestra la lista de pacientes.
     */
    public function index(Request $request)
    {
        $pacientes = Paciente::orderBy('id', 'desc')->paginate(10);
        if ($request->ajax()) {
            // Solo devolvemos el contenido parcial (sin layout)
            return view('partials.pacientes.index', compact('pacientes'))->render();
        }

        // 🔹 Si se accede directamente, devolver el layout principal
        return view('layouts.app');
    }

    /**
     * Muestra el formulario para crear un nuevo paciente.
     */
    public function create()
    {
        $estado_civiles = EdoCivil::where('activo', true)->get();
        $ocupaciones = Ocupacion::where('activo', true)->get();
        $escolaridades = Escolaridad::where('activo', true)->get();
        $padecimientos = Padecimiento::get();
        $tipos_cirugia = CirugiaTipo::get();
        $tipos_alergia = collect([
            (object)[ 'id' => 1, 'nombre' => 'Alimentos' ],
            (object)[ 'id' => 2, 'nombre' => 'Medicamentos' ],
            (object)[ 'id' => 3, 'nombre' => 'Ambientales' ],
        ]);
        $paciente = null;
        return view('partials.pacientes.form', compact('estado_civiles', 'ocupaciones', 'escolaridades', 'padecimientos', 'paciente', 'tipos_cirugia', 'tipos_alergia'));
    }

    /**
     * Guarda un nuevo paciente en la base de datos.
     */
    public function store(PacienteRequest $request)
    { 
        $request->sucursal_id = auth()->user()->sucursal_id;
        $paciente = Paciente::create($request->except('padecimientos'));
        $paciente->padecimientos()->sync($request->padecimientos);
         // 🔹 Procesar imagen si se subió
         if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath())->cover(800, 800);
    
            // Carpeta y nombre del archivo
            $folder = "paciente/{$paciente->id}";
            $filename = uniqid('paciente_') . '.jpg';
            $relativePath = "$folder/$filename";
    
            // Crear la carpeta si no existe
            Storage::makeDirectory($folder);
    
            // Guardar la imagen dentro de storage/app/public/
            Storage::disk('public')->put($relativePath, (string) $image->encode(new JpegEncoder(quality: 80)));
    
            // Guardar la ruta accesible públicamente
            $paciente->profile_photo_path = "storage/paciente/{$paciente->id}/{$filename}";

            $paciente->save();
    
            Log::info("Imagen guardada correctamente", ['path' => $paciente->profile_photo_path]);
        }

        if ($request->has('cirugia_tipo')) {
            $this->syncCirugias($paciente, $request->only('cirugia_id', 'cirugia_tipo', 'cirugia_fecha', 'cirugia_notas','cirugia_otro'));
        }
        if ($request->has('hospitalizacion_motivo')) {
            $this->syncHospitalizaciones($paciente, $request->only('hospitalizacion_id', 'hospitalizacion_motivo', 'hospitalizacion_ingreso', 'hospitalizacion_alta', 'hospitalizacion_hospital', 'hospitalizacion_notas'));
        }
        if ($request->has('alergia_tipo')) {
            $this->syncAlergias($paciente, $request->only('alergia_id', 'alergia_tipo', 'alergia_nombre', 'alergia_notas'));
        }

        // 🔹 Respuesta AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Paciente creado correctamente.',
                'user' => $paciente,
            ]);
        }

        return redirect()->route('pacientes.index')->with('success', 'Paciente creado correctamente.');
    }

    /**
     * Muestra los datos de un paciente.
     */
    public function show(Paciente $paciente)
    {
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(Paciente $paciente)
    {
        $estado_civiles = EdoCivil::where('activo', true)->get();
        $ocupaciones = Ocupacion::where('activo', true)->get();
        $escolaridades = Escolaridad::where('activo', true)->get();
        $padecimientos = Padecimiento::get();
        $tipos_cirugia = CirugiaTipo::get(); // Aquí podrías cargar los tipos de cirugías si es necesario
        $tipos_alergia = collect([
            (object)[ 'id' => 1, 'nombre' => 'Alimentos' ],
            (object)[ 'id' => 2, 'nombre' => 'Medicamentos' ],
            (object)[ 'id' => 3, 'nombre' => 'Ambientales' ],
        ]);

        return view('partials.pacientes.form', compact('paciente', 'estado_civiles', 'ocupaciones', 'escolaridades', 'padecimientos', 'tipos_cirugia', 'tipos_alergia'));
    }

    /**
     * Actualiza los datos de un paciente.
     */
    public function update(PacienteRequest $request, Paciente $paciente)
    {
        Log::info($request->all());

        $paciente->padecimientos()->sync($request->padecimientos);
        Log::info($request->all());
        $paciente->update($request->all());
        if ($request->has('cirugia_tipo')) {
            $this->syncCirugias($paciente, $request->only('cirugia_id', 'cirugia_tipo', 'cirugia_fecha', 'cirugia_notas','cirugia_otro'));
        }
        if ($request->has('hospitalizacion_motivo')) {
            $this->syncHospitalizaciones($paciente, $request->only('hospitalizacion_id', 'hospitalizacion_motivo', 'hospitalizacion_ingreso', 'hospitalizacion_alta', 'hospitalizacion_hospital', 'hospitalizacion_notas'));
        }
        if ($request->has('alergia_tipo')) {
            $this->syncAlergias($paciente, $request->only('alergia_id', 'alergia_tipo', 'alergia_nombre', 'alergia_notas'));
        }

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath())->cover(800, 800);
    
            // Carpeta y nombre del archivo
            $folder = "paciente/{$paciente->id}";
            $filename = uniqid('paciente_') . '.jpg';
            $relativePath = "$folder/$filename";
    
            // Crear la carpeta si no existe
            Storage::makeDirectory($folder);
    
            // Guardar la imagen dentro de storage/app/public/
            Storage::disk('public')->put($relativePath, (string) $image->encode(new JpegEncoder(quality: 80)));
    
            // Guardar la ruta accesible públicamente
            $paciente->profile_photo_path = "storage/paciente/{$paciente->id}/{$filename}";

            $paciente->save();
    
            Log::info("Imagen guardada correctamente", ['path' => $paciente->profile_photo_path]);
        }
        // 🔹 Respuesta AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Paciente actualizado correctamente.',
                'user' => $paciente,
            ]);
        }

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado correctamente.');
    }

    /**
     * Elimina un paciente.
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();

        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado correctamente.');
    }

    private function syncCirugias(Paciente $paciente, array $data)
    {
        // Verifica que exista al menos un array de tipos
        if (!isset($data['cirugia_tipo'])) return;

        $ids = $data['cirugia_id'] ?? [];
        $tipos = $data['cirugia_tipo'];
        $otros = $data['cirugia_otro'] ?? [];
        $fechas = $data['cirugia_fecha'] ?? [];
        $notas = $data['cirugia_notas'] ?? [];

        $cirugiasAConservar = [];

        for ($i = 0; $i < count($tipos); $i++) {
            // Ignora si no hay tipo y no hay fecha
            if (!$tipos[$i] && empty($fechas[$i])) continue;

            if (!empty($ids[$i])) {
                // Actualizar cirugía existente
                $cirugia = $paciente->cirugias()->where('id', $ids[$i])->first();
                if ($cirugia) {
                    $cirugia->update([
                        'cirugia_tipo_id' => $tipos[$i],
                        'cirugia_otro' => $otros[$i] ?? null,
                        'fecha' => $fechas[$i],
                        'notas' => $notas[$i] ?? null,
                    ]);
                    $cirugiasAConservar[] = $cirugia->id;
                }
            } else {
                // Crear cirugía nueva
                $nuevo = $paciente->cirugias()->create([
                    'cirugia_tipo_id' => $tipos[$i],
                    'cirugia_otro' => $otros[$i] ?? null,
                    'fecha' => $fechas[$i],
                    'notas' => $notas[$i] ?? null,
                ]);
                $cirugiasAConservar[] = $nuevo->id;
            }
        }

        // Borrar cirugías eliminadas visualmente
        $paciente->cirugias()
            ->whereNotIn('id', $cirugiasAConservar)
            ->delete();
    }

    private function syncHospitalizaciones(Paciente $paciente, array $data)
    {
        if (!isset($data['hospitalizacion_motivo'])) return;

        $ids = $data['hospitalizacion_id'] ?? [];
        $motivos = $data['hospitalizacion_motivo'];
        $ingresos = $data['hospitalizacion_ingreso'] ?? [];
        $altas = $data['hospitalizacion_alta'] ?? [];
        $hospitales = $data['hospitalizacion_hospital'] ?? [];
        $notas = $data['hospitalizacion_notas'] ?? [];

        $hospitalizacionesAConservar = [];

        for ($i = 0; $i < count($motivos); $i++) {
            // Ignora si no hay tipo y no hay fecha
            if (!$motivos[$i] && empty($ingresos[$i])) continue;

            if (!empty($ids[$i])) {
                // Actualizar cirugía existente
                $hospitalizacion = $paciente->hospitalizaciones()->where('id', $ids[$i])->first();
                if ($hospitalizacion) {
                    $hospitalizacion->update([
                        'motivo' => $motivos[$i],
                        'fecha_ingreso' => $ingresos[$i] ?? null,
                        'fecha_alta' => $altas[$i],
                        'hospital' => $hospitales[$i] ?? null,
                        'notas' => $notas[$i] ?? null,
                    ]);
                    $hospitalizacionesAConservar[] = $hospitalizacion->id;
                }
            } else {
                // Crear cirugía nueva
                $nuevo = $paciente->hospitalizaciones()->create([
                    'motivo' => $motivos[$i],
                    'fecha_ingreso' => $ingresos[$i] ?? null,
                    'fecha_alta' => $altas[$i],
                    'hospital' => $hospitales[$i] ?? null,
                    'notas' => $notas[$i] ?? null,
                ]);
                $hospitalizacionesAConservar[] = $nuevo->id;
            }
        }

        // Borrar cirugías eliminadas visualmente
        $paciente->hospitalizaciones()
            ->whereNotIn('id', $hospitalizacionesAConservar)
            ->delete();
    }
    
    private function syncAlergias(Paciente $paciente, array $data)
    {
        if (!isset($data['alergia_tipo'])) return;

        $ids = $data['alergia_id'] ?? [];
        $tipos = $data['alergia_tipo'];
        $nombres = $data['alergia_nombre'];
        $notas = $data['alergia_notas'] ?? [];

        $alergiasAConservar = [];

        for ($i = 0; $i < count($tipos); $i++) {
            // Ignora si no hay tipo y no hay nombre
            if (!$tipos[$i] && empty($nombres[$i])) continue;

            if (!empty($ids[$i])) {
                // Actualizar cirugía existente
                $alergia = $paciente->alergias()->where('id', $ids[$i])->first();
                if ($alergia) {
                    $alergia->update([
                        'tipo' => $tipos[$i],
                        'nombre' => $nombres[$i],
                        'notas' => $notas[$i] ?? null,
                    ]);
                    $alergiasAConservar[] = $alergia->id;
                }
            } else {
                // Crear cirugía nueva
                $nuevo = $paciente->alergias()->create([
                    'tipo' => $tipos[$i],
                    'nombre' => $nombres[$i],
                    'notas' => $notas[$i] ?? null,
                ]);
                $alergiasAConservar[] = $nuevo->id;
            }
        }

        // Borrar cirugías eliminadas visualmente
        $paciente->alergias()
            ->whereNotIn('id', $alergiasAConservar)
            ->delete();
    }


}
