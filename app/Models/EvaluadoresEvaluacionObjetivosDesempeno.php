<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluadoresEvaluacionObjetivosDesempeno extends Model
{
    use HasFactory;

    protected $table = 'evaluadores_evaluacion_objetivos_desempenos';

    protected $fillable = [
        'evaluado_desempeno_id',
        'evaluador_desempeno_id',
        'porcentaje_objetivos',
        'finalizada',
        'firma_evaluacion',
    ];

    public function preguntasCuestionario()
    {
        return $this->hasMany(CuestionarioObjetivoEvDesempeno::class, 'evaluador_desempeno_id', 'id');
    }

    public function preguntasCuestionarioAplican()
    {
        return $this->hasMany(CuestionarioObjetivoEvDesempeno::class, 'evaluador_desempeno_id', 'id')
            ->where('aplicabilidad', true);
    }
}