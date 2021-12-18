<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * Class DeclaracionAplicabilidadResponsable.
 *
 * @property int $id
 * @property int|null $declaracion_id
 * @property int|null $empleado_id
 * @property character varying|null $aplica
 * @property string|null $justificacion
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * @property string|null $deleted_at
 *
 * @property DeclaracionAplicabilidad|null $declaracion_aplicabilidad
 * @property Empleado|null $empleado
 */
class DeclaracionAplicabilidadResponsable extends Model
{
    use SoftDeletes;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'declaracion_aplicabilidad_responsables';

    protected $casts = [
        'declaracion_id' => 'int',
        'empleado_id' => 'int',
    ];

    protected $fillable = [
        'declaracion_id',
        'empleado_id',
        'aplica',
        'justificacion',
        'notificado',
    ];

    public function declaracion_aplicabilidad()
    {
        return $this->belongsTo(DeclaracionAplicabilidad::class, 'declaracion_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function notificacion()
    {
        return $this->hasMany(NotificacionAprobadores::class, 'responsables_id', 'id');
    }
}
