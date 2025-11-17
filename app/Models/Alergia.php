<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergia extends Model
{
    protected $fillable = [
        'paciente_id',
        'alergia_tipo_id',
        'alergia_nombre',
        'notas',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

}
