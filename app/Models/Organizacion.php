<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
/**
 * Class Organizacion.
 *
 * @property int $id
 * @property string $empresa
 * @property string $direccion
 * @property int|null $telefono
 * @property string|null $correo
 * @property string|null $pagina_web
 * @property string|null $giro
 * @property string|null $servicios
 * @property string|null $mision
 * @property string|null $vision
 * @property string|null $valores
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $team_id
 * @property string|null $antecedentes
 * @property string|null $logotipo
 *
 * @property Team|null $team
 * @property Collection|Sede[] $sedes
 */
class Organizacion extends Model
{
    use SoftDeletes;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'organizacions';

    protected $casts = [
        'telefono' => 'int',
        'team_id' => 'int',
    ];

    protected $fillable = [
        'empresa',
        'direccion',
        'telefono',
        'correo',
        'pagina_web',
        'giro',
        'servicios',
        'mision',
        'vision',
        'valores',
        'team_id',
        'antecedentes',
        'logotipo',
        'razon_social',
        'rfc',
        'representante_legal',
        'fecha_constitucion',
        'num_empleados',
        'tamano',

    ];

    public function getLogotipoAttribute($value)
    {
        $logotipo = asset('img/logo_policromatico_2.png');
        if ($value) {
            $logotipo = asset('storage/images/' . $value);
        }

        return $logotipo;
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function sedes()
    {
        return $this->hasMany(Sede::class);
    }
}
