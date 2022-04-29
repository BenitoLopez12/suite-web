<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class MatrizRiesgosSistemaGestionControlesPivot extends Model
{
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'matriz_riesgos_sistema_gestion_controles_pivot';

    protected $casts = [
        'matriz_id' => 'int',
        'controles_id' => 'int',
    ];

    protected $fillable = [
        'matriz_id',
        'controles_id',
    ];

    public function declaracion_aplicabilidad()
    {
        return $this->belongsTo(DeclaracionAplicabilidad::class, 'controles_id');
    }

    public function matriz_riesgo()
    {
        return $this->belongsTo(MatrizRiesgosSistemaGestion::class, 'matriz_id');
    }
}
