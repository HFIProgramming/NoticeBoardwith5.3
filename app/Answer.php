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
        'user_id', 'option_id', 'content',
    ];

    /**
     * Hidden
     * @var array
     */
    protected $hidden = [
    ];

}
