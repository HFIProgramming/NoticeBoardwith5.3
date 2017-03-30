<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubUser extends Model
{
    //
	/**
	 * Table Name
	 *
	 * @var string
	 */
	protected $table = 'club_user';
  
	public function user()
	{
		$this->belongsTo('App\User','user_id','id');
	}

	public function club()
	{
		$this->belongsTo('App\Club','club_id','id');
	}

	public function getUserStatus(){

	}

	public function isBlackList(){

	}

}
