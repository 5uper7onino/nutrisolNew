<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente;
use App\Models\ConsultaFoto;

class Consulta extends Model
{
    protected $fillable = [
        'paciente_id',
        'peso_kg',
        'estatura_cm',
        'cintura_cm',
        'cadera_cm',
        'cuello_cm',
        'imc',
        'icc',
        'igc',
    ];
    

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function fotos()
    {
        return $this->hasMany(ConsultaFoto::class);
    }
}

