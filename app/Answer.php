<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'vote_answers';

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

    public function option(){
        return $this->belongsTo('App\Option', 'id', 'option_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'id', 'user_id');
    }

}
