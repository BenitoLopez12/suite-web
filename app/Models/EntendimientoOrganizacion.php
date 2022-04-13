<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

class EntendimientoOrganizacion extends Model
{
    use HasFactory;
    use SoftDeletes;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'entendimiento_organizacions';
    protected $fillable = [
        'fortalezas',
        'oportunidades',
        'debilidades',
        'amenazas',
        'analisis',
        'fecha',
        'id_elabora',

    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_elabora', 'id');
    }

    public function fodafortalezas()
	{
		return $this->hasMany(FortalezasEntendimientoOrganizacion::class, 'foda_id','id');
	}

    public function fodaoportunidades()
	{
		return $this->hasMany(OportunidadesEntendimientoOrganizacion::class, 'foda_id','id');
	}

    public function fodadebilidades()
	{
		return $this->hasMany(DebilidadesEntendimientoOrganizacion::class, 'foda_id','id');
	}

    public function fodamenazas()
	{
		return $this->hasMany(AmenazasEntendimientoOrganizacion::class, 'foda_id','id');
	}

    public function participantes()
    {
        return $this->belongsToMany(Empleado::class, 'participantes_entendimiento_organizacion', 'foda_id', 'empleado_id')->with('area');
    }
}
