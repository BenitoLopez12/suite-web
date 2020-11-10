<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Registromejora extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'registromejoras';

    public static $searchable = [
        'nombre',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const PRIORIDAD_SELECT = [
        'alta'  => 'Alta',
        'media' => 'Media',
        'Baja'  => 'Baja',
    ];

    protected $fillable = [
        'nombre_reporta_id',
        'nombre',
        'prioridad',
        'clasificacion',
        'descripcion',
        'responsableimplementacion_id',
        'participantes',
        'recursos',
        'beneficios',
        'valida_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function mejoraDmaics()
    {
        return $this->hasMany(Dmaic::class, 'mejora_id', 'id');
    }

    public function mejoraPlanMejoras()
    {
        return $this->hasMany(PlanMejora::class, 'mejora_id', 'id');
    }

    public function nombre_reporta()
    {
        return $this->belongsTo(User::class, 'nombre_reporta_id');
    }

    public function responsableimplementacion()
    {
        return $this->belongsTo(User::class, 'responsableimplementacion_id');
    }

    public function valida()
    {
        return $this->belongsTo(User::class, 'valida_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
