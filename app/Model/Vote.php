<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
	/**
	 * Massive assign
	 *
	 * @var array
	 */
	protected $fillable = [
		'title', 'type', 'started_at', 'ended_at', 'intro',
	];

	/**
	 * Related to question
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function questions()
	{
		return $this->hasMany('App\Question');
	}

	/**
	 * get user model
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('App\User', 'creator_id', 'id');
	}

	/**
	 * id of voted User
	 *
	 * @return mixed
	 */
	public function votedIds()
	{
		return $this->questions->map(function ($question) {
			return $question->options->map(function ($option) {
				return $option->answers->map(function ($answer) {
					return $answer->source->id;
				});
			});
		})->flatten()->unique();
	}

	/**
	 * Popular search ID
	 *
	 * @param $query
	 * @param $id
	 * @return mixed
	 */
	public function scopeId($query, $Id)
	{
		return $query->where('id', $Id)->firstOrFail();
	}

	/**
	 * Return the vote group to which the vote belongs.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function voteGroup()
	{
		return $this->belongsTo('App\VoteGroup');
	}
}
