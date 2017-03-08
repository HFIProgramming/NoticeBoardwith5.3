<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
	/**
	 * Massive assign
	 *
	 * @var array
	 */
	protected $fillable = [
		'type', 'content',
	];

	/**
	 * Table name plz
	 *
	 * @var string
	 */
	protected $table = 'question_options';

	/**
	 * Trace back to the question
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function question()
	{
		return $this->belongsTo('App\Question', 'question_id', 'id');
	}

	/**
	 * Option Counts
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function answers()
	{
		return $this->hasMany('App\Answer', 'option_id', 'id');
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

	/**
	 * Get total number of people who choose certain option
	 *
	 * @return int
	 */
	public function getTotalNumber()
	{
		return count($this->answers);
	}
}
