<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ejemplo: puedes enviar datos desde aquí
        $mensaje = "Hola desde el controlador Home 🎉";
        $fecha = now()->format('d/m/Y H:i:s');
        if ($request->ajax()) {
            // Solo devolvemos el contenido parcial (sin layout)
            return view('partials.home', compact('mensaje', 'fecha'));
        }
        // Enviamos variables a la vista
        return redirect()->route('root');
    }
}
