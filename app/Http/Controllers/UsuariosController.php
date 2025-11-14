<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Hash;
use App\Models\Sucursal;
use Log;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = \App\Models\User::paginate(10);

        // 🔹 Si la petición es AJAX (desde fetch)
        if ($request->ajax()) {
            // Solo devolvemos el contenido parcial (sin layout)
            return view('partials.usuarios.index', compact('usuarios'))->render();
        }

        // 🔹 Si se accede directamente, devolver el layout principal
        return view('layouts.app');
    }



    public function create()
    {
        
        $sucursales = Sucursal::select('id', 'nombre')->get();
        return view('partials.usuarios.form', ['usuario' => null, 'sucursales' => $sucursales]);
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $sucursales = Sucursal::select('id', 'nombre')->get();

        return view('partials.usuarios.form', compact('usuario', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'is_admin' => 'sometimes|boolean',
            'password' => 'required|min:6',
            'sucursal_id' => 'required|exists:sucursales,id',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
    
        // Crear usuario base
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin') ? 1 : 0,
            'password' => bcrypt($request->password),
            'sucursal_id' => $request->sucursal_id,
        ]);
    
        // 🔹 Procesar imagen si se subió
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath())->cover(800, 800);
    
            // Carpeta y nombre del archivo
            $folder = "users/{$user->id}";
            $filename = uniqid('user_') . '.jpg';
            $relativePath = "$folder/$filename";
    
            // Crear la carpeta si no existe
            Storage::makeDirectory($folder);
    
            // Guardar la imagen dentro de storage/app/public/
            Storage::disk('public')->put($relativePath, (string) $image->encode(new JpegEncoder(quality: 80)));
    
            // Guardar la ruta accesible públicamente
            //$user->profile_photo_path = "storage/$relativePath";
            $user->profile_photo_path = "storage/users/{$user->id}/{$filename}";

            $user->save();
    
            Log::info("Imagen guardada correctamente", ['path' => $user->profile_photo_path]);
        }
    
        // 🔹 Respuesta AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario creado correctamente.',
                'user' => $user
            ]);
        }
    
        // 🔹 Respuesta normal
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }


    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'is_admin' => 'sometimes|boolean',
            'password' => 'nullable|min:6',
            'profile_photo' => 'nullable|image|max:4096', // 4MB máximo
        ]);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->is_admin = $request->has('is_admin') ? 1 : 0;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        // 🔹 Manejo de imagen
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath())->cover(800, 800);
    
            // Carpeta y nombre del archivo
            $folder = "users/{$usuario->id}";
            $filename = uniqid('user_') . '.jpg';
            $relativePath = "$folder/$filename";
    
            // Crear la carpeta si no existe
            Storage::makeDirectory($folder);
    
            // Guardar la imagen dentro de storage/app/public/
            Storage::disk('public')->put($relativePath, (string) $image->encode(new JpegEncoder(quality: 80)));
    
            // Guardar la ruta accesible públicamente
            //$usuario->profile_photo_path = "storage/$relativePath";
            $usuario->profile_photo_path = "storage/users/{$usuario->id}/{$filename}";

            $usuario->save();
    
        }


        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente.',
            'user' => $usuario,
            'photo_url' => $usuario->profile_photo_path ? Storage::url($usuario->profile_photo_path) : null,
        ]);
    }
}
