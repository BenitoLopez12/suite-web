<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActividadAccionCorrectiva extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'actividades_accion_correctiva';

    protected $guarded = ['id'];

    public function accionCorrectiva()
    {
        return $this->belongsTo(AccionCorrectiva::class, 'accion_correctiva_id', 'id');
    }

    public function responsables()
    {
        return $this->belongsToMany(Empleado::class, 'actividades_accion_correctiva_responsables', 'actividad_id', 'responsable_id');
    }
}
