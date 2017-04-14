<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'chinese_name', 'english_name', 'name', 'email', 'password', 'phone_number', 'wechat', 'avatar', 'active', 'grade',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @TODO Think about this: should user phone number and wechat be leaked?
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token', 'email', 'powerschool_id', 'role', 'id', 'active', 'created_at', 'updated_at'
	];


	// Attribute

	/**
	 * default avatar
	 *
	 * @param $value
	 * @return string
	 */
	public function getAvatarAttribute($value)
	{
		return empty($value) ? 'https://ww4.sinaimg.cn/small/006dLiLIgw1fawexxhv3hj31hc1hcdzh.jpg' : 'https://hfinotice-images.nos-eastchina1.126.net/%2Favatar%2F' . $value;
	}


	// Query
  
	/**
	 * scope username with this function
	 *
	 * @param $query
	 * @param $username
	 * @return mixed
	 */
	public function scopeUsername($query, $type, $username)
	{
		return $query->where($type, $username);
	}

	// Relationship
  
	/**
	 * List the Posts from a specific user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */
	public function posts()
	{
		return $this->hasMany('App\Post', 'user_id', 'id');
	}

	/**
	 * List the user's votes.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function votes()
	{
		return $this->hasMany('App\Vote', 'creator_id', 'id');
	}

	/**
	 * List user's vote result
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function answers()
	{
		return $this->morphMany('App\Answer', 'source');
	}

	/**
	 * Login Addresses
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function ipAddress()
	{
		return $this->morphMany('App\IPAddress', 'source');
	}

	/**
	 * Link User to clubs
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function clubs()
	{
		return $this->belongsToMany('App\Club', 'club_users', 'user_id','club_id')->withPivot('role','status')->withTimestamps();
	}

	/**
	 * Link File User
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function file(){
		return $this->hasMany('App\File','user_id','id');
	}

	// Function

	/**
	 * Check if User has voted in specific Vote
	 *
	 * @param $voteId
	 * @return bool
	 */
	public function isUserVoted($voteId)
	{

		return $this->answers->map(function ($answer) {
				return $answer->option->question->vote->id;
			})->flatten()->search($voteId) === false;

	}

}
