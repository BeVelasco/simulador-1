<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Costeo extends Model
{
    protected $table = 'costeoproductos';

    protected $fillable = [
		'id_user',
		'id_producto',
		'data',
		'PBBD',
		'dataPrecioVenta',
	];

	protected $hidden = [
		'id',
	];

}
