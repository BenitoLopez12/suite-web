<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

class PerfilEmpleado extends Model
{
    use HasFactory, SoftDeletes;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'perfil_empleados';
    // protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'nombre',
        'descripcion',
        'created_at',
        'updated_at',
    ];

    public function empleados()
    {
        return $this->hasMany('App\Models\Empleado', 'perfil_empleado_id', 'id');
    }


    public function puestos()
    {
        return $this->hasMany('App\Models\Empleado', 'perfil_empleado_id', 'id');
    }
}
