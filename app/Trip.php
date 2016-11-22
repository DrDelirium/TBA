<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{

	protected $fillable = ['name', 'flights'];
	protected $hidden = ['created_at', 'updated_at'];

}
