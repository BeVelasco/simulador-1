<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catum extends Model
{
	protected $table = 'catums';
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'idesc', 'icode', 'state'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'id',
	];

	public function producto()
    {
        return $this->belongsTo('App\Producto', 'idcatnum1');
	}
	
	public function scopeGetCatumSortBy($query, $col)
	{
		return $query->get()->sortBy($col);
	}

	public function scopeGetCatumCount($query)
	{
		return $query->get()->count();
	}
}
