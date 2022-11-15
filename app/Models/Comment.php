<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'event_id', 'content', 'edited', 'created_at', 'updated_at'
    ];

    public function event() { return $this->belongsTo(Event::class); }

    public function user() { return $this->belongsTo(User::class); }
    public function Notification() { return $this->hasOne(CommentNotification::class); }

    public function answers() { return $this->hasMany(Answer::class); }

    public function votes() { return $this->hasMany(Vote::class); }
}
