<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	/**
	 * Massive assign
	 *
	 * @var array
	 */
	protected $fillable = [

	];

	/**
	 * Hidden
	 *
	 * @var array
	 */
	protected $hidden = [

	];

	/**
	 * popular search for ticket
	 *
	 * @param $query
	 * @param $string
	 * @return mixed
	 */
	public function scopeTicket($query, $string)
	{
		return $query->where('string', $string);
	}

    /**
     * Return votes associated with the ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        return $this->belongsToMany('App\Vote');
	}

}
