<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
	protected $table = 'prueba';
    protected $fillable = ['entrance_id','user_id', 'floor', 'apt_number','percent_ideal_parts','starting_balance','animals','other_information'];
}