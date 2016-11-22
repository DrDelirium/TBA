<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{

	protected $fillable = ['name', 'country', 'code'];
	protected $hidden = ['created_at', 'updated_at'];

	/**
	 * Returns all the flight that starts from this airport.
	 *
	 * @return Collection
	 */
	public function origin() {
			return $this->hasMany('App\Flight', 'origin', 'code');
	}

	/**
	 * Returns all the flight that ends at this airport.
	 *
	 * @return Collection
	 */
	public function destinations() {
			return $this->belongsTo('App\Flight', 'destination', 'code');
	}

}
