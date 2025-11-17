<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospitalizacion extends Model
{
    protected $table = 'hospitalizaciones';
    protected $fillable = [
        'paciente_id',
        'motivo',
        'fecha_ingreso',
        'fecha_alta',
        'hospital',
        'notas',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
