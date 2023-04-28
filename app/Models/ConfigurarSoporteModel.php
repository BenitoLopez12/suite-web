<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurarSoporteModel extends Model
{
    use HasFactory;

    // public $cacheFor = 3600;
    // protected static $flushCacheOnUpdate = true;
    public $table = 'configuracion_soporte';

    protected $fillable = [
        'rol',
        'puesto',
        'telefono',
        'extension',
        'tel_celular',
        'correo',
        'id_elaboro',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_elaboro')->alta();
    }
}
