<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{

	protected $fillable = ['name', 'country', 'code'];
	protected $hidden = ['created_at', 'updated_at'];

	// each airport can have many flight starting from them
	public function origin() {
			return $this->hasMany('App\Flight', 'origin', 'code');
	}

	// each airport can be the destination of many flights
	public function destinations() {
			return $this->belongsTo('App\Flight', 'destination', 'code');
	}

}
