<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Padecimiento;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'fecha_inicio',
        'sexo',
        'curp',
        'ocupacion_id',
        'escolaridad_id',
        'estado_civil_id',
        'fuma',
        'fumador_desde',
        'fumador_cantidad',
        'toma',
        'toma_frecuencia',
        'hace_ejercicio',
        'tipo_ejercicio',
        'tuvo_covid',
        'covid_fecha',
        'fracturas',
        'detalle_fracturas',
        'medicamentos_actuales',
        'telefono',
        'email',
        'direccion',
        'municipio',
        'estado',
        'sucursal_id',
    ];

    protected $dates = [
        'fecha_nacimiento',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function padecimientos()
    {
        return $this->belongsToMany(Padecimiento::class);
    }

    public function cirugias()
    {
        return $this->hasMany(Cirugia::class);
    }
    
    public function hospitalizaciones()
    {
        return $this->hasMany(Hospitalizacion::class);
    }

    public function alergias()
    {
        return $this->hasMany(Alergia::class);
    }
    

}
