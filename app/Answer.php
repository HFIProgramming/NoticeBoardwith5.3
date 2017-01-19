<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * Massive assign
     * @var array
     */
    protected $fillable = [
        'option_id', 'content',
    ];

    /**
     * Hidden
     * @var array
     */
    protected $hidden = ['user_id',
    ];

}
