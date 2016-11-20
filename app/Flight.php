<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{

	protected $fillable = ['origin', 'destination'];
	protected $hidden = ['created_at', 'updated_at'];

}
