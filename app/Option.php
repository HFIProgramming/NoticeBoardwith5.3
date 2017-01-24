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
    public function question(){
        return $this->belongsTo('App\Question');
    }

}
