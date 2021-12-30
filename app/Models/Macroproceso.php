<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * Class Macroproceso.
 *
 * @property int $id
 * @property string|null $codigo
 * @property string|null $nombre
 * @property int|null $id_grupo
 * @property string|null $descripcion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Grupo|null $grupo
 * @property Collection|Proceso[] $procesos
 */
class Macroproceso extends Model
{
    use SoftDeletes;
    use HasFactory;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;

    protected $table = 'macroprocesos';

    protected $dates = ['deleted_at'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $casts = [
        'id_grupo' => 'int',
    ];

    protected $fillable = [
        'codigo',
        'nombre',
        'id_grupo',
        'descripcion',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }

    public function procesos()
    {
        return $this->hasMany(Proceso::class, 'id_macroproceso');
    }

    public function procesosWithDocumento()
    {
        return $this->hasMany(Proceso::class, 'id_macroproceso')->with('documento');
    }
}
