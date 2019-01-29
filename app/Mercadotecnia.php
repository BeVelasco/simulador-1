<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mercadotecnia extends Model
{
	protected $fillable = ['tipoMercadotecnia','precio','canalesDistribucion','promocion','relacionesPublicas','clientesInternos','total'];
	protected $hidden   = ['user_id','id_producto',];
}
