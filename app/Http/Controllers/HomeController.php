<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ejemplo: puedes enviar datos desde aquí
        $mensaje = "Hola desde el controlador Home 🎉";
        $fecha = now()->format('d/m/Y H:i:s');

        // Enviamos variables a la vista
        return view('partials.home', compact('mensaje', 'fecha'));
    }
}
