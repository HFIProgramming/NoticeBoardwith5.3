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
}
