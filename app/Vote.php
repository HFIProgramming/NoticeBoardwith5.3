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
     * @var array
     */
    protected $hidden = [
        'voted_user',
    ];


    public function questions()
    {
        return $this->hasMany('App\Question');
    }

}
