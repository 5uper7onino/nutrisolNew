<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdoCivil extends Model
{
    protected $table = 'edo_civil';

    protected $fillable = [
        'nombre',
        'activo',
    ];
}
