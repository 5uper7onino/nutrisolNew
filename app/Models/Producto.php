<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'tipo_id',
        'coste',
    ];

    public function menus(){
        return $this->belongsToMany(Menu::class, 'menu_producto', 'producto_id', 'menu_id')
                    ->withPivot('cantidad','coste_unitario', 'coste_total')
                    ->withTimestamps();
    }
}
