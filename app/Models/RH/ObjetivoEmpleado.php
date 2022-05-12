<?php

namespace App\Models\RH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjetivoEmpleado extends Model
{
    use HasFactory;
    protected $table = 'ev360_objetivo_empleados';
    protected $fillable = ['empleado_id', 'objetivo_id', 'completado', 'en_curso'];

    public function objetivo()
    {
        return $this->belongsTo('App\Models\RH\Objetivo', 'objetivo_id', 'id');
    }
}
