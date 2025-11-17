<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escolaridad extends Model
{
    protected $table = 'escolaridad';

    protected $fillable = [
        'nombre',
        'activo',
    ];
}
