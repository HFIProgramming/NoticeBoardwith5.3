<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	protected $table = 'vote_answers';

	/**
	 * Massive assign
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'option_id', 'content',
	];

	/**
	 * multi connection
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function source()
	{
		return $this->morphTo();
	}


	/**
	 * Trace back the option
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function option()
	{
		return $this->belongsTo('App\Option', 'option_id', 'id');
	}

	/**
	 * Trace back the user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

}
