<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'content',
	];

	/**
	 * Hidden
	 *
	 * @var array
	 */
	protected $hidden = [
		'user_id', 'is_prohibited', 'reason', 'post_id',
	];


	/**
	 * Trace back the post
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 */
	public function post()
	{
		return $this->belongsTo('App\Post', 'post_id','id');
	}

	/**
	 * Get author of a specific comment
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 */
	public function getAuthor()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

}
