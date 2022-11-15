<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function event() { return $this->belongsTo(Event::class); }

    public function user() { return $this->belongsTo(User::class); }
    public function Notification() { return $this->hasOne(CommentNotification::class); }

    public function answers() { return $this->hasMany(Answer::class); }
}
