<?php

namespace App\Models\RH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objetivo extends Model
{
    use HasFactory, SoftDeletes;
    // public $cacheFor = 3600;
    // protected static $flushCacheOnUpdate = true;

    protected $table = 'ev360_objetivos';
    protected $appends = ['imagen_ruta'];
    protected $guarded = ['id'];

    const APROBADO = 1;
    const RECHAZADO = 2;
    const SIN_DEFINIR = 0;

    public function getImagenRutaAttribute()
    {
        if ($this->imagen) {
            return asset('storage/objetivos/img/' . $this->imagen);
        }

        return asset('img/bullseye.png');
    }

    public function metrica()
    {
        return $this->belongsTo('App\Models\RH\MetricasObjetivo', 'metrica_id', 'id');
    }

    public function tipo()
    {
        return $this->belongsTo('App\Models\RH\TipoObjetivo', 'tipo_id', 'id');
    }

    public function calificacion()
    {
        return $this->belongsTo('App\Models\RH\ObjetivoCalificacion', 'objetivo_id', 'id');
    }

    public function comentarios()
    {
        return $this->belongsToMany('App\Models\RH\ObjetivoComentario', 'ev360_objetivos_comentarios_pivot', 'objetivo_id', 'comentario_id');
    }
}
