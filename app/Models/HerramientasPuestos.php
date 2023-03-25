<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HerramientasPuestos extends Model
{
    use HasFactory;

    protected $table = 'herramientas_puesto';

    protected $fillable = [
        'nombre_herramienta',
        'descripcion_herramienta',
        'puesto_id',
    ];

    public function puesto()
    {
        return $this->hasMany('App\Model\Puesto');
    }
}
