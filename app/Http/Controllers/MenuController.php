<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menus = \App\Models\Menu::paginate(10);
        if ($request->ajax()) {
            // Solo devolvemos el contenido parcial (sin layout)
            return view('partials.menus.index', compact('menus'))->render();
        }
    
        // 🔹 Si se accede directamente, devolver el layout principal
        return view('layouts.app');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipos = \App\Models\TipoMenu::all();
        $temporadas = \App\Models\Temporada::all();
        return view('partials.menus.form', ['menu' => null, 'tipos' => $tipos, 'temporadas' => $temporadas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'comensales' => 'required|integer|min:1',
            'tipo_id' => 'required|exists:tipos_menu,id',
            'temporada_id' => 'required|exists:temporadas,id',
        ]);

        $menu = Menu::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'comensales' => $request->comensales,
            'tipo_id' => $request->tipo_id,
            'temporada_id' => $request->temporada_id,
        ]);

        // 🔹 Si la petición es AJAX (desde fetch)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario creado correctamente.',
                'menu' => $menu
            ]);
        }

        return redirect()->route('menus.index')->with('success', 'Menú creado correctamente.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);
        $tipos = \App\Models\TipoMenu::all();
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'comensales' => 'required|integer|min:1',
            'tipo_id' => 'required|exists:tipos_menu,id',
            'temporada_id' => 'required|exists:temporadas,id',
        ]);
        $menu->nombre = $request->nombre;
        $menu->descripcion = $request->descripcion;
        $menu->comensales = $request->comensales;
        $menu->tipo_id = $request->tipo_id;
        $menu->temporada_id = $request->temporada_id;
        $menu->save();
        // 🔹 Si la petición es AJAX (desde fetch
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Menú actualizado correctamente.',
                'menu' => $menu
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
