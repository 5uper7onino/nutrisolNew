<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

// Ruta que sirve el layout principal (la aplicación con header/footer)
Route::get('/', function () {
    return view('layouts.app'); // asegúrate de crear esta vista abajo
})->name('root');

// Ruta para el contenido parcial de Home (se pide por AJAX)
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios');
Route::get('/usuarios/crear', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::get('/usuarios/{user}/editar', [UsuariosController::class, 'edit'])->name('usuarios.edit');
Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');
Route::put('/usuarios/{id}', [UsuariosController::class, 'update'])->name('usuarios.update');

Route::get('/productos',[ProductosController::class,'index'])->name('productos');
Route::get('/productos/crear',[ProductosController::class,'create'])->name('productos.create');
Route::post('/productos',[ProductosController::class,'store'])->name('productos.store');
Route::get('/productos/{producto}/editar',[ProductosController::class,'edit'])->name('productos.edit');
Route::put('/productos/{id}',[ProductosController::class,'update'])->name('productos.update');

Route::get('/menus',[MenuController::class,'index'])->name('menus');
Route::get('/menus/crear',[MenuController::class,'create'])->name('menus.create');
Route::post('/menus',[MenuController::class,'store'])->name('menus.store');
Route::get('/menus/{menu}/editar',[MenuController::class,'edit'])->name('menus.edit');
Route::put('/menus/{id}',[MenuController::class,'update'])->name('menus.update');
