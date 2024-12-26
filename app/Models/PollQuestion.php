<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollQuestion extends Model
{
    protected $fillable = ['user_id','title', 'is_private', 'start_time', 'end_time', 'status','max_votes'];

    public function options()
    {
        return $this->hasMany(PollOption::class, 'question_id');
    }

    public function votes()
    {
        return $this->hasMany(PollVote::class, 'question_id');
    }
}
