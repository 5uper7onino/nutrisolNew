<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TipoMenu;
use App\Models\Temporada;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'nombre',
        'descripcion',
        'comensales',
        'tipo_id',
        'temporada_id',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoMenu::class, 'tipo_id');
    }

    public function temporada()
    {
        return $this->belongsTo(Temporada::class, 'temporada_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'menu_productos', 'menu_id', 'producto_id')
                    ->withPivot('cantidad','coste_unitario', 'coste_total')
                    ->withTimestamps();
    }   
}
