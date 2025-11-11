<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Models\Sucursal;

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
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
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
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $filename = uniqid('user_') . '.jpg';

            // Redimensionar (si la imagen es más grande que 800x800) y comprimir
            $imageResized = Image::make($image)
                ->orientate()
                ->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize(); // evita estirarla si es más pequeña
                })
                ->encode('jpg', 70); // 70% calidad para buena compresión

            // Guardar en storage/app/public/usuarios
            Storage::disk('public')->put("usuarios/{$filename}", $imageResized);

            // Guardar la ruta en el campo profile_photo_path
            $user->profile_photo_path = "usuarios/{$filename}";
            $user->save();
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
            // Borramos la anterior si existe
            if ($usuario->profile_photo_path && Storage::exists($usuario->profile_photo_path)) {
                Storage::delete($usuario->profile_photo_path);
            }

            $image = $request->file('profile_photo');
            $fileName = uniqid('user_') . '.' . $image->getClientOriginalExtension();

            // 🔹 Comprimir con Intervention Image
            $img = Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode(null, 75); // calidad 75%

            $path = "users/{$fileName}";
            Storage::put($path, (string) $img);

            $usuario->profile_photo_path = $path;
        }

        $usuario->save();

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente.',
            'user' => $usuario,
            'photo_url' => $usuario->profile_photo_path ? Storage::url($usuario->profile_photo_path) : null,
        ]);
    }
}
