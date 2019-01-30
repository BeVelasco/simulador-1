<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'idesc',
		'state',
		'id_user_r',
		'idcatnum1',
		'idcatnum2',
		'idcatnum3',
		'icode',
		'porcionpersona'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'user_id',
	];

	/**
     * Obtiene los productos asociados al usuario.
     */
	public function catum()
    {
        return $this->hasOne('App\Catum', 'id', 'idcatnum1');
	}

	public function scopeGetTotalProducts($query, $idUser)
	{
      return $query->where('id_user_r', $idUser)->count();
	}

	public function scopeCheckProductExists($query, $idUser, $idesc)
	{
		 return $query->where(['idesc'=>$idesc,'id_user_r'=>$idUser])->count();
	}  

	public function scopeGetProductosPaginated($query, $idUser, $paginate)
	{
		return $query->where('id_user_r', $idUser)->paginate($paginate);
	}
}
