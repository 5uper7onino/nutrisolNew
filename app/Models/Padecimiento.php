<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente;

class Padecimiento extends Model
{
    protected $fillable = ['nombre'];

    public function pacientes()
    {
        return $this->belongsToMany(Paciente::class);
    }
}
