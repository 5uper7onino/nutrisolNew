<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CirugiaTipo extends Model
{
    protected $fillable = ['nombre'];

    public function cirugias()
    {
        return $this->hasMany(Cirugia::class);
    }
}
