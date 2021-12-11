<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Rennokki\QueryCache\Traits\QueryCacheable;
class Competencium extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, HasFactory;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    public $table = 'competencia';

    protected $appends = [
        'certificados',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'nombrecolaborador_id',
        'perfilpuesto',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function nombrecolaborador()
    {
        return $this->belongsTo(User::class, 'nombrecolaborador_id');
    }

    public function getCertificadosAttribute()
    {
        return $this->getMedia('certificados');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    // public function empleado()
    // {
    //     return $this->belongsTo(Empleado::class, 'id_empleado', 'id')->with('area');
    // }
}
