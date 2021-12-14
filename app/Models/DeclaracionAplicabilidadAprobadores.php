<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * Class DeclaracionAplicabilidadAprobadore.
 *
 * @property int $id
 * @property int|null $declaracion_id
 * @property int|null $aprobadores_id
 * @property int|null $estatus
 * @property Carbon|null $fecha_aprobacion
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * @property string|null $deleted_at
 *
 * @property DeclaracionAplicabilidad|null $declaracion_aplicabilidad
 * @property Empleado|null $empleado
 */
class DeclaracionAplicabilidadAprobadores extends Model
{
    use SoftDeletes;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'declaracion_aplicabilidad_aprobadores';

    protected $casts = [
        'declaracion_id' => 'int',
        'aprobadores_id' => 'int',
        'estatus' => 'int',
    ];

    protected $dates = [
        'fecha_aprobacion',
    ];

    protected $fillable = [
        'declaracion_id',
        'aprobadores_id',
        'estatus',
        'fecha_aprobacion',
    ];

    public function declaracion_aplicabilidad()
    {
        return $this->belongsTo(DeclaracionAplicabilidad::class, 'declaracion_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'aprobadores_id');
    }
}
