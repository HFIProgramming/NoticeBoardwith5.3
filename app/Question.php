<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * Massive assign
     * @var array
     */
    protected $fillable = [
        'type', 'content', 'explanation',
    ];

    /**
     * Hidden
     * @var array
     */
    protected $hidden = [
        'range', 'vote_id',
    ];

    protected $table = 'vote_questions';

    /**
     * related to options
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options(){
        return $this->hasMany('App\Option', 'question_id', 'id');
    }

}
