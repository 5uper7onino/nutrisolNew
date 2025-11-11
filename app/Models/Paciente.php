<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'sexo',
        'curp',
        'telefono',
        'email',
        'direccion',
        'municipio',
        'estado',
    ];

    protected $dates = [
        'fecha_nacimiento',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

}
