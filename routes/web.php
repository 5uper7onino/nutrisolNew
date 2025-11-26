<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ConsultaController;
// Si no hay usuario autenticado → mandar al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Todo lo demás debe estar autenticado
Route::middleware(['auth'])->group(function () {

    // Layout principal después del login
    Route::get('/', function () {
        return view('layouts.app');
    })->name('root');

    // Contenidos cargados por AJAX
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Usuarios
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios');
    Route::get('/usuarios/crear', [UsuariosController::class, 'create'])->name('usuarios.create');
    Route::get('/usuarios/{user}/editar', [UsuariosController::class, 'edit'])->name('usuarios.edit');
    Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [UsuariosController::class, 'update'])->name('usuarios.update');

    // Productos
    Route::get('/productos', [ProductosController::class, 'index'])->name('productos');
    Route::get('/productos/crear', [ProductosController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/editar', [ProductosController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [ProductosController::class, 'update'])->name('productos.update');

    // Menús
    Route::get('/menus', [MenuController::class, 'index'])->name('menus');
    Route::get('/menus/crear', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}/editar', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{id}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');

    // Pacientes
    Route::resource('pacientes', PacienteController::class);

    //Citas
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::get('/citas/create', [CitaController::class, 'create'])->name('citas.create');

    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/data', [CitaController::class, 'data']);
    Route::get('/citas/{cita}/confirm-delete', [CitaController::class, 'confirmDelete']);
    Route::delete('/citas/{cita}', [CitaController::class, 'destroy'])->name('citas.destroy');
    
    // Consultas
    //Route::get('/pacientes/{paciente}/consultas', [ConsultaController::class, 'index']);
    //Route::get('/consultas/{id}', [ConsultaController::class, 'show']);
    Route::get('/consultas/{id}/crear', [ConsultaController::class, 'create'])->name('consultas.create');
    Route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');
    //Route::put('/consultas/{id}', [ConsultaController::class, 'update']);
    //Route::delete('/consultas/{id}', [ConsultaController::class, 'destroy']);
//
    //Route::delete('/consulta-foto/{id}', [ConsultaController::class, 'deleteFoto']);
//

});
