<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuestionarioProporcionaInformacionAIA extends Model
{
    use HasFactory;
    public $table = 'propociona_informacion_aia';

    public $fillable = [
        'id',
        'nombre',
        'puesto',
        'correo_electronico',
        'extencion',
        'ubicacion',
        'cuestionario_id',
        'interno_externo',

    ];

    public function cuestionario()
    {
        return $this->belongsTo(AnalisisAIA::class, 'cuestionario_id', 'id');
    }
}
