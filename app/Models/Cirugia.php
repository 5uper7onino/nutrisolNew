<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cirugia extends Model
{
    protected $fillable = [
        'paciente_id',
        'cirugia_tipo_id',
        'cirugia_otro',
        'fecha',
        'notas',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function tipo()
    {
        return $this->belongsTo(CirugiaTipo::class, 'cirugia_tipo_id');
    }
}
