<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * Massive assign
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * Hidden
     * @var array
     */
    protected $hidden = [
        'active', 'is_used', 'string', 'vote_id',
    ];

    /**
     * popular search for ticket
     * @param $query
     * @param $string
     * @return mixed
     */
    public function scopeTicket($query,$string){
        return $query->where('string',$string);
    }
}
