<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected $fillable = ['question_id', 'option'];

    public function question()
    {
        return $this->belongsTo(PollQuestion::class, 'question_id');
    }

    public function votes()
    {
        return $this->hasMany(PollVote::class, 'option_id');
    }
}
