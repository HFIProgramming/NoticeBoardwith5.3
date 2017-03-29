<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	use \Conner\Tagging\Taggable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'content', 'title', 'is_public', 'is_hidden', 'level_limitation', 'background',
	];

	/**
	 * Attached comments to the post
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */
	public function hasManyComments()
	{
		return $this->hasMany('App\Comment', 'post_id', 'id');
	}

	/**
	 * Get Author of specific post
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 */
	public function getAuthor()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	/**
	 * Find who make the last reply of current Post
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 */
	public function getLastUser()
	{
		return $this->belongsTo('App\User', 'last_user', 'id');
	}

	/**
	 * Popular search Id
	 *
	 * @param $query
	 * @param $Id
	 * @return mixed
	 */


}
