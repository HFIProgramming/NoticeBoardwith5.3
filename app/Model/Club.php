<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
	//
	public function users()
	{
		return $this->belongsToMany(User::class, 'club_users', 'club_id','user_id')->using();
	}

	/*
	public function applicants()
	{
		return $this->belongsToMany('App\User', 'club_users', 'club_id','user_id')->wherePivot('role','applicant');
	}
	*/

	public function scopeId($query, $Id)
	{
		return $query->where('id', $Id)->firstOrFail();
	}

}
