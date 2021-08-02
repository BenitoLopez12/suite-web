<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Grupo
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $descripcion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|Area[] $areas
 * @property Collection|Macroproceso[] $macroprocesos
 *
 * @package App\Models
 */
class Grupo extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'grupos';

	protected $dates = ['deleted_at'];

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';

	protected $fillable = [
		'nombre',
		'descripcion',
		'color'
	];

	// protected $appends = ['color_group'];

	public function areas()
	{
		return $this->hasMany(Area::class, 'id_grupo');
	}

	// public function getColorGroupAttribute()
	// {
	// 	return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
	// }

	public function macroprocesos()
	{
		return $this->hasMany(Macroproceso::class, 'id_grupo');
	}

	public function team()
	{
		return $this->belongsTo(Team::class, 'team_id');
	}
}
