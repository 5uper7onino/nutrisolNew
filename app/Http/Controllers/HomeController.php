<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Consulta;


class HomeController extends Controller
{
    public function index()
    {
        return view('partials.home', [
            'proximasCitas'   => Cita::where('inicio', '>=', now())->orderBy('inicio')->take(5)->get(),
            'pacientesNuevos' => Paciente::orderBy('created_at', 'desc')->take(5)->get(),
            'consultasMes'    => Consulta::whereMonth('fecha', now()->month)->count(),
            'ultimosAtendidos'=> Consulta::orderBy('fecha', 'desc')->take(6)->get(),
        ]);
    }
    
}
