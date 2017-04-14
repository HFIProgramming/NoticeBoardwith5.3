<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
	//

	/*
	 * table name
	 */
	protected $table = 'clubs';

	// Relationship

	public function users($status = NULL, $data = NULL)
	{
		if (empty($status) || empty($data)) {
			return $this->belongsToMany('App\User', 'club_users', 'club_id', 'user_id')->withPivot('role', 'status')->withTimestamps();
		}
		return $this->belongsToMany('App\User', 'club_users', 'club_id', 'user_id')->wherePivot($status, $data)->withPivot('role', 'status')->withTimestamps();
	}


	public function scopeId($query, $Id)
	{
		return $query->where('id', $Id)->firstOrFail();
	}

}
