<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
	//
	public function users()
	{
		return $this->belongsToMany('App\User', 'club_users', 'club_id','user_id')->withTimestamps();
	}

	


}
