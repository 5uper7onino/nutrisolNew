<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Producto;
use App\Models\TipoMenu;
use App\Models\Temporada;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menus = Menu::paginate(15);
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
        $productos = Producto::all();
        $tipos = TipoMenu::all();
        $temporadas = Temporada::all();
        return view('partials.menus.form', ['menu' => null, 'tipos' => $tipos, 'temporadas' => $temporadas, 'productos' => $productos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'comensales' => 'required|integer|min:1',
            'tipo_id' => 'required|exists:tipos_menu,id',
            'temporada_id' => 'required|exists:temporadas,id',
        ]);
        */
        $menu = Menu::create($request->only(['nombre','descripcion','comensales','tipo_id','temporada_id']));
        if ($request->has('productos')) {
            foreach ($request->productos as $producto) {
                $coste_unitario = Producto::find($producto['producto_id'])->coste;
                $menu->productos()->attach($producto['producto_id'], [
                    'cantidad' => $producto['cantidad'],
                    'coste_unitario' => $coste_unitario,
                    'coste_total' => $producto['cantidad'] * $coste_unitario,
                ]);
            }
        }
        // 🔹 Si la petición es AJAX (desde fetch)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Menú creado correctamente.',
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
        $menu = Menu::findOrFail($id);
        $tipos = \App\Models\TipoMenu::all();
        $temporadas = \App\Models\Temporada::all();
        $productos = \App\Models\Producto::select('id','nombre','coste')->get();
        $productosSeleccionados = $menu->productos->map(function ($p) {
            return [
                'producto_id' => (int) $p->pivot->producto_id,
                'cantidad' => (float) $p->pivot->cantidad,
            ];
        });
        //dd($productosSeleccionados);
        return view('partials.menus.form', ['menu' => $menu , 'tipos' => $tipos, 'temporadas' => $temporadas, 'productos' => $productos, 'productosSeleccionados' => $productosSeleccionados]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $menu = Menu::findOrFail($id);
        $menu->update($request->only(['nombre','descripcion','comensales','tipo_id','temporada_id']));
        /*$request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'comensales' => 'required|integer|min:1',
            'tipo_id' => 'required|exists:tipos_menu,id',
            'temporada_id' => 'required|exists:temporadas,id',
        ]);*/
        Log::info('Actualizando menú: ' . json_encode($request->productos));
        if ($request->has('productos')) {
            $syncData = [];
        
            foreach ($request->productos as $producto) {
                $coste_unitario = Producto::find($producto['producto_id'])->coste;
                $syncData[$producto['producto_id']] = [
                    'cantidad' => $producto['cantidad'],
                    'coste_unitario' => $coste_unitario,
                    'coste_total' => $producto['cantidad'] * $coste_unitario,
                ];
            }
        
            // Reemplaza los productos existentes por los nuevos
            $menu->productos()->sync($syncData);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Menú creado correctamente.',
                    'menu' => $menu
                ]);
            }
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
