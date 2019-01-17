<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaMensual extends Model
{
	protected $table = "ventas_mensuales";
     /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id_user',
		'id_producto',
		'mes',
		'porcentaje',
		'unidades',
		'precioVenta',
		'total',
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
