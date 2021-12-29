<?php

namespace App\Models;

use App\Traits\DateTranslator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Support\Str;
use Jenssegers\Date\Date;

class CertificacionesEmpleados extends Model
{
    use SoftDeletes;
    use QueryCacheable;
    use DateTranslator;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'certificaciones_empleados';

    protected $dates = [
        'vigencia',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'empleado_id' => 'int',
        'nombre' => 'string',
        'estatus' => 'string',
    ];

    protected $fillable = [
        'empleado_id',
        'nombre',
        'estatus',
        'vigencia',
        'documento',

    ];

    protected $appends = ['vigencia_ymd', 'ruta_documento', 'vigencia_string_formated'];

    public function getVigenciaStringFormatedAttribute($date)
    {
        Date::setLocale('es');
        return new Date($date);
    }

    public function getRutaDocumentoAttribute()
    {
        return asset('storage/certificados_empleados/') . '/' . $this->documento;
    }

    public function getVigenciaYmdAttribute()
    {
        if ($this->vigencia) {
            return Carbon::parse($this->vigencia)->format('Y-m-d');
        } else {
            return null;
        }
    }

    public function empleado_certificaciones()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function getVigenciaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }
}
