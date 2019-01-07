<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
	protected $table = 'avancesimulador';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'seccion',
		'realizado',
		'id_user'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'id',
	];}
