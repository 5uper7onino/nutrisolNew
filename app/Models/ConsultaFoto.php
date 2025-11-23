<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaFoto extends Model
{
    protected $fillable = [
        'consulta_id',
        'tipo',
        'path',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
