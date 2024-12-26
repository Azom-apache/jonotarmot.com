<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    protected $fillable = ['question_id', 'option_id', 'ip_address','local_ip_address'];

    public function question()
    {
        return $this->belongsTo(PollQuestion::class, 'question_id');
    }

    public function option()
    {
        return $this->belongsTo(PollOption::class, 'option_id');
    }
}
