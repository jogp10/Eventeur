<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentNotification extends Model
{
    use HasFactory;

    public function notification() { return $this->hasOne(Notification::class); }

    public function comment() { return $this->hasOne(Comment::class); }

}
