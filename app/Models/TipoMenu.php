<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMenu extends Model
{
    protected $table = 'tipos_menu';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
