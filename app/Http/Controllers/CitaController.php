<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitaController extends Controller
{
    //

    public function index(Request $request)
    {
        $menus = [];

        if ($request->ajax()) {
            // Solo devolvemos el contenido parcial (sin layout)
            return view('partials.citas.index', compact('menus'))->render();
        }
        return view('partials.citas.index');
    }
}
