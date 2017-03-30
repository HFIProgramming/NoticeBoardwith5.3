<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
	//

	/*
	 * table name
	 */
	protected $table = 'club_user';


	public function users()
	{
		return $this->belongsToMany('App\User', 'club_users', 'club_id','user_id')->withPivot('role','status')->withTimestamps();
	}

	public function getBlacklistApplicants()
	{

	}

	public function scopeId($query, $Id)
	{
		return $query->where('id', $Id)->firstOrFail();
	}

}
