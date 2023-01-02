<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'content', 'seen'
   ];

    public function user() { return $this->belongsTo(User::class); }
    
    public function inviteNotification() { return $this->hasOne(InviteNotification::class); }

    public function commentNotification() { return $this->hasOne(CommentNotification::class); }
}
