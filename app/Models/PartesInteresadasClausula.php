<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PartesInteresadasClausula
 *
 * @property int $id
 * @property int $clausula_id
 * @property int $partesint_id
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 *
 * @property Clausula $clausula
 * @property PartesInteresada $partes_interesada
 *
 * @package App\Models
 */
class PartesInteresadasClausula extends Model
{
	protected $table = 'partes_interesadas_clausula';

	protected $casts = [
		'clausula_id' => 'int',
		'partesint_id' => 'int',
	];

	protected $fillable = [
		'clausula_id',
		'partesint_id'
	];

	public function clausula()
	{
		return $this->belongsTo(Clausula::class);
	}

	public function partes_interesada()
	{
		return $this->belongsTo(PartesInteresada::class, 'partesint_id');
	}
}
