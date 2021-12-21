<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

class ActividadIncidente extends Model
{
    use HasFactory, SoftDeletes;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'actividades_incidentes';

    protected $guarded = ['id'];

    public function incidente_seguridad()
    {
        return $this->belongsTo(IncidentesSeguridad::class, 'seguridad_id', 'id');
    }

    public function responsables()
    {
        return $this->belongsToMany(Empleado::class, 'actividades_incidentes_responsables', 'actividad_id', 'responsable_id');
    }
}
