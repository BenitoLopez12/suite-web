<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioDocumentos extends Model
{
    use HasFactory;

    // public $cacheFor = 3600;
    // protected static $flushCacheOnUpdate = true;
    public $table = 'envio_documentos';

    protected $fillable = [
        'status',
        'id_solicita',
        'id_coordinador',
        'id_mensajero',
        'hora_recepcion_inicio',
        'hora_recepcion_fin',
        'fecha_solicitud',
        'fecha_limite',
        'descripcion',
        'lugar',
        'destinatario',
        'notas',
        'telefono',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    public function solicita()
    {
        return $this->belongsTo(Empleado::class, 'id_solicita')->alta();
    }

    public function coordinador()
    {
        return $this->belongsTo(Empleado::class, 'id_coordinador')->alta();
    }

    public function mensajero()
    {
        return $this->belongsTo(Empleado::class, 'id_mensajero')->alta();
    }
}
