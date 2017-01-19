<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * Massive assign
     * @var array
     */
    protected $fillable = [
        'type', 'content',
    ];

    /**
     * Hidden
     * @var array
     */
    protected $hidden = ['question_id',
    ];

    protected $table = 'question_options';

    public function question(){
        return $this->belongsTo('App\Question');
    }

}
