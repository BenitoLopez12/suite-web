<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

class ActividadSugerencia extends Model
{
    use HasFactory, SoftDeletes;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'actividades_sugerencias';

    protected $guarded = ['id'];

    public function sugerencia()
    {
        return $this->belongsTo(Sugerencias::class, 'sugerencia_id', 'id');
    }

    public function responsables()
    {
        return $this->belongsToMany(Empleado::class, 'actividades_sugerencias_responsables', 'actividad_id', 'responsable_id');
    }
}
