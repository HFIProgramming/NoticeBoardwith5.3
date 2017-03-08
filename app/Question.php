<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	/**
	 * Massive assign
	 *
	 * @var array
	 */
	protected $fillable = [
		'type', 'content', 'explanation',
	];

	protected $table = 'vote_questions';

	/**
	 * Related to options
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function options()
	{
		return $this->hasMany('App\Option', 'question_id', 'id');
	}

	/**
	 * Trace back to the vote
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function vote()
	{
		return $this->belongsTo('App\Vote', 'vote_id', 'id');
	}

	/**
	 * Get total number of people who answer the question
	 *
	 * @return mixed
	 */
	public function getTotalNumber(){
		return $this->options->map(function ($option) {
			return count($option->answers);
		})->flatten()->sum();
	}
}
