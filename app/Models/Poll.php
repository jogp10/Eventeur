<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'question', 'created_at', 'updated_at'
    ];

    public $usersThatVoted = array();

    public function event() { return $this->belongsTo(Event::class); }

    public function pollOptions() { return $this->hasMany(PollOption::class); }

    public function addUserToVotedList($user) {
        $this->usersThatVoted[] = $user;
    }

    public function checkIfUserVoted($user) {
        return in_array($user, $this->usersThatVoted);
    }
}
