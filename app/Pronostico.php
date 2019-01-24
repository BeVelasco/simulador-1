<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pronostico extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id_user',
		'id_producto',
		'regionObjetivo',
		'totalPersonas',
		'segmentacion',
		'poblacionNeta',
		'nivelSocioeconomico',
		'mercadoPotencial',
		'estimacionDemanda',
		'mercadoDisponible',
		'mercadoEfectivo',
		'mercadoObjetivo',
		'consumoAnual',
		'proyeccionVentas',
		'totalUnidades',
		'tasaCreVen',
		'mesInicio'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'id',
	];
}
