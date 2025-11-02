<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productos = Producto::paginate(10);
        Log::info('ProductosController@index: ' . json_encode($productos));
        // 🔹 Si la petición es AJAX (desde fetch)
        if ($request->ajax()) {
            // Solo devolvemos el contenido parcial (sin layout)
            return view('partials.productos.index', compact('productos'))->render();
        }
    
        // 🔹 Si se accede directamente, devolver el layout principal
        return view('layouts.app');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partials.productos.form', ['producto' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        Log::info('ProductosController@edit: ' . json_encode($producto));
        return view('partials.productos.form', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'coste' => 'required|numeric',
        ]);

        $producto->nombre = $request->nombre;
        $producto->coste = $request->coste;
        $producto->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
