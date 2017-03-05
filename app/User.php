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
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * default avatar
	 *
	 * @param $value
	 * @return string
	 */
	public function getAvatarAttribute($value)
	{
		return empty($value) ? 'https://ww4.sinaimg.cn/small/006dLiLIgw1fawexxhv3hj31hc1hcdzh.jpg' : $value;
	}

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

	/**
	 * List the Posts from a specific user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */
	public function posts()
	{
		return $this->hasMany('App\Post');
	}

    /**
     * List the user's votes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany('App\Vote', 'creator_id');
	}
}
