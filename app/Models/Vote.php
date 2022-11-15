<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'poll_option_id', 'created_at', 'updated_at'
    ];

    public function user() { return $this->belongsTo(User::class); }

    public function pollOptions() { return $this->belongsTo(PollOption::class); }

    public function event() { return $this->belongsTo(Event::class); }


    public function comment() { return $this->belongsTo(Comment::class); }


    public function answer() { return $this->belongsTo(Answer::class); }

}
