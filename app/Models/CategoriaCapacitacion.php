<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
class CategoriaCapacitacion extends Model
{
    use HasFactory, SoftDeletes;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $table = 'categoria_capacitacions';

    protected $fillable = ['nombre'];

    public function recursos()
    {
        return $this->hasMany(Recurso::class);
    }
}
