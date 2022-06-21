<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * Class VariablesObjetivosseguridad.
 *
 * @property int $id
 * @property int|null $id_objetivo
 * @property character varying|null $variable
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Objetivosseguridad|null $objetivosseguridad
 */
class VariablesObjetivosseguridad extends Model
{
    use SoftDeletes;

    protected $table = 'variables_objetivosseguridad';

    protected $dates = ['deleted_at'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $casts = [
        'id_objetivo' => 'int',
        'variable' => 'string',
    ];

    protected $fillable = [
        'id_objetivo',
        'variable',
    ];

    public function objetivosseguridad()
    {
        return $this->belongsTo(Objetivosseguridad::class, 'id_objetivo');
    }
}
