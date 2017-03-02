<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
	/**
	 * Massive assign
	 * @var array
	 */
	protected $fillable = [
		'title', 'type', 'started_at', 'ended_at', 'intro',
	];

	/**
	 * Hidden
	 *
	 * @var array
	 */
	protected $hidden = [

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

	public function getAuthor()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function votedUserIds()
	{
		return $this->questions->map(function ($question, $key) {
			return $question->options->map(function ($option, $key) {
				return $option->answers->map(function ($answer, $key) {
					return $answer->user_id;
				});
			});
		})->flatten()->unique()->toarray();
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
		return $query->where('id', $Id);
	}
}
