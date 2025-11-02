<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        return view('partials.usuarios.form', ['usuario' => null]);
    }
    
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('partials.usuarios.form', compact('usuario'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'is_admin' => 'sometimes|boolean',
            'password' => 'required|min:6',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin') ? 1 : 0,
            'password' => bcrypt($request->password),
        ]);
    
        // 🔹 Si la petición es AJAX (desde fetch)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario creado correctamente.',
                'user' => $user
            ]);
        }
    
        // 🔹 Si es formulario normal
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }
    
    

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'is_admin' => 'sometimes|boolean',
            'password' => 'nullable|min:6'
        ]);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->is_admin = $request->has('is_admin') ? 1 : 0;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return response()->json(['success' => true]);
    }
}
