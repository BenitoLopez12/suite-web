<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditoriaInternasHallazgos extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'auditoria_internas_hallazgos';


    protected $fillable = [
        'incumplimiento_requisito',
        'descripcion',
        'clasificacion_hallazgo',
        'auditoria_internas_id',
        'area_id',
        'proceso_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function auditoriaInterna()
    {
        return $this->belongsTo(AuditoriaInterna::class, 'auditoria_internas_id');
    }

    public function procesos()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function areas()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
