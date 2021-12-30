<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AccionCorrectiva extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, HasFactory, QueryCacheable;
    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    public $table = 'accion_correctivas';

    protected $appends = [
        'documentometodo',
        'folio',
    ];

    public static $searchable = [
        'tema',
        'causaorigen',
    ];

    const ESTATUS_SELECT = [
        'por_iniciar' => 'Por iniciar',
        'en_proceso'  => 'En proceso',
        'terminado'   => 'Terminado',
    ];

    const METODO_CAUSA_SELECT = [
        'lluvia_ideas' => 'Lluvia de ideas',
        'cinco_porque' => 'Cinco porqués',
        'Ishikawa'     => 'Ishikawa',
    ];

    protected $dates = [
        'fecharegistro',
        'fecha_compromiso',
        'fecha_verificacion',
        'fecha_cierre',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const CAUSAORIGEN_SELECT = [
        'desviacion_proceso'    => 'Desviación en los procesos',
        'queja_cliente'         => 'Queja de un cliente',
        'auditoria_interna'     => 'Auditoría Interna',
        'desviacion_inicadores' => 'Desviación a los indicadores',
        'incumplimiento_ns'     => 'Incumplimiento a los niveles de servicio',
        'otro'                  => 'Otro',
    ];

    protected $fillable = [
        'fecharegistro',
        'tema',
        'causaorigen',
        'descripcion',
        'metodo_causa',
        'solucion',
        'cierre_accion',
        'estatus',
        'fecha_compromiso',
        'fecha_verificacion',
        'responsable_accion_id',
        'nombre_autoriza_id',
        'id_registro',
        'id_reporto',
        'id_responsable_accion',
        'id_responsable_autorizacion',
        'areas',
        'procesos',
        'activos',
        'comentarios',
        'fecha_cierre',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    public function getFolioAttribute()
    {
        return  sprintf('AC-%04d', $this->id);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function accioncorrectivaPlanaccionCorrectivas()
    {
        return $this->hasMany(PlanaccionCorrectiva::class, 'accioncorrectiva_id', 'id');
    }

    // public function getFechaRegistroAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    // }

    // public function getFechaCompromisoAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    // }

    // public function getFechaVerificacionAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    // }

    public function nombrereporta()
    {
        return $this->belongsTo(User::class, 'nombrereporta_id');
    }

    public function puestoreporta()
    {
        return $this->belongsTo(Puesto::class, 'puestoreporta_id');
    }

    public function nombreregistra()
    {
        return $this->belongsTo(User::class, 'nombreregistra_id');
    }

    public function puestoregistra()
    {
        return $this->belongsTo(Puesto::class, 'puestoregistra_id');
    }

    public function responsable_accion()
    {
        return $this->belongsTo(User::class, 'responsable_accion_id');
    }

    public function nombre_autoriza()
    {
        return $this->belongsTo(User::class, 'nombre_autoriza_id');
    }

    public function getDocumentometodoAttribute()
    {
        return $this->getMedia('documentometodo')->last();
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function empleados()
    {
        return $this->belongsTo(Empleado::class, 'id_registro', 'id')->with('area');
    }

    public function reporto()
    {
        return $this->belongsTo(Empleado::class, 'id_reporto', 'id')->with('area');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id', 'id');
    }

    public function activo()
    {
        return $this->belongsTo(Tipoactivo::class, 'activo_id', 'id');
    }

    public function planes()
    {
        return $this->morphToMany(PlanImplementacion::class, 'plan_implementacionable');
    }

    public function actividades()
    {
        return $this->hasMany(ActividadAccionCorrectiva::class, 'accion_correctiva_id', 'id');
    }
}
