<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'seen'
   ];

    public function inviteNotification() { return $this->hasOne(InviteNotification::class); }

    public function commentNotification() { return $this->hasOne(CommentNotification::class); }
}
