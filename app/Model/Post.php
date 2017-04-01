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
	 * Content censor
	 *
	 * @param $value
	 * @return string
	 */
	public function getContentAttribute($value)
	{
		return $this->is_prohibited ? (empty($this->reason) ? __('post.is_prohibited_general') : __('post.is_prohibited', ['reason' => $this->reason])) : $value;
	}


	/**
	 * Attached comments to the post
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */

	public function comments()
	{
		return $this->hasMany('App\Comment', 'post_id', 'id');
	}

	/**
	 * Get Author of specific post
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 */
	public function user()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	/**
	 * Popular search Id
	 *
	 * @param $query
	 * @param $Id
	 * @return mixed
	 */
	public function scopeId($query, $Id)
	{
		return $query->where('id', $Id)->firstOrFail();
	}


}
