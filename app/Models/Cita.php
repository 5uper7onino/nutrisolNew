<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'paciente_id',
        'inicio',
        'fin',
        'nota'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
