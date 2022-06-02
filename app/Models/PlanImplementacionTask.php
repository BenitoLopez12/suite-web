<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

class PlanImplementacionTask extends Model
{
    use HasFactory, SoftDeletes;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'plan_implementacion_tasks';
    protected $fillable = [
        'name',
        'progress',
        'progressByWorklog',
        'description',
        'level',
        'status',
        'depends',
        'start',
        'duration',
        'end',
        'startIsMilestone',
        'endIsMilestone',
        'collapsed',
        'canWrite',
        'canAdd',
        'canDelete',
        'canAddIssue',
        'id_fase',
        'id_task',
        'url',
        'plan_implementacion_id',
    ];

    public function plan()
    {
        return $this->belongsTo(PlanImplementacion::class, 'plan_implementacion_id', 'id');
    }

    public function assigs()
    {
        return $this->belongsToMany(Empleado::class, 'empleado_task')->alta();
    }
}
