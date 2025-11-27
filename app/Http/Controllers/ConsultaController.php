<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\ConsultaFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Paciente;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Drivers\Gd\Driver;

class ConsultaController extends Controller
{
    /**
     * Listado de consultas de un paciente.
     */
    public function index(Request $request,$paciente_id)
    {
        $consultas = Consulta::where('paciente_id', $paciente_id)
            ->with('fotos')
            ->orderBy('fecha', 'desc')
            ->get();

            if ($request->ajax()) {
                // Solo devolvemos el contenido parcial (sin layout)
                return response()->json($consultas);;
            }
            return redirect()->route('home');
        
    }

    public function create($id)
    {
        //dd("en crear consulta");
        $paciente = Paciente::findOrFail($id);
            // Solo devolvemos el contenido parcial (sin layout)
            return view('partials.consultas.form', compact('paciente'));
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
    { Log::info($request);
        $request->validate([
            'peso'      => 'nullable|numeric',
            'altura'    => 'nullable|numeric',
            'cintura'   => 'nullable|numeric',
            'cadera'    => 'nullable|numeric',
            'cuello'    => 'nullable|numeric',
            'imc'       => 'nullable|numeric',
            'icc'       => 'nullable|numeric',
            'igc'       => 'nullable|numeric',
            'descripcion' => 'nullable|string',
            'plan'        => 'nullable|string',

            // Validación de fotos
            'foto_frente'  => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'foto_espalda' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'foto_brazo'   => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'foto_pierna'  => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'foto_perfil'  => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $paciente = Paciente::findOrFail($request->paciente_id);

        // Crear la consulta
        $consulta = new Consulta();
        $consulta->fecha   = now();
        $consulta->paciente_id = $paciente->id;
        $consulta->peso    = $request->peso;
        $consulta->altura  = $request->altura;
        $consulta->cintura = $request->cintura;
        $consulta->cadera  = $request->cadera;
        $consulta->cuello  = $request->cuello;
        $consulta->imc     = $request->imc;
        $consulta->icc     = $request->icc;
        $consulta->igc     = $request->igc;
        $consulta->descripcion = $request->descripcion;
        $consulta->plan        = $request->plan;
        $consulta->save();

        // Guardar fotos
        $fotos = [
            'foto_frente',
            'foto_espalda',
            'foto_brazo',
            'foto_pierna',
            'foto_perfil',
        ];

        foreach ($fotos as $campo) {
            $ruta = $this->savePhoto($request, $campo, $paciente->id);
            if ($ruta) {
                $consulta->{$campo} = $ruta;
            }
        }

        $consulta->save();

        return response()->json([
            'ok' => true,
            'message' => 'Consulta registrada correctamente.',
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

    private function savePhoto(Request $request, string $inputName, int $pacienteId)
    {
        if (!$request->hasFile($inputName)) {
            return null;
        }

        try {
            $file = $request->file($inputName);

            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath())->cover(800, 800);

            // Carpeta y nombre
            $folder = "paciente/{$pacienteId}";
            $filename = uniqid("{$inputName}_") . '.jpg';
            $relativePath = "$folder/$filename";

            // Crear carpeta
            Storage::makeDirectory($folder);

            // Guardar en storage/app/public
            Storage::disk('public')->put($relativePath, (string) $image->encode(new JpegEncoder(quality: 80)));

            // Ruta pública
            return "storage/paciente/{$pacienteId}/{$filename}";

        } catch (\Exception $e) {
            Log::error("Error guardando imagen $inputName", ['error' => $e->getMessage()]);
            return null;
        }
    }

}
