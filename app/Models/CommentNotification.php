<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'notification_id', 'comment_id', 'created_at', 'updated_at'
    ];

    public function user() { return $this->belongsTo(User::class); }
    
    public function notification() { return $this->belongsTo(Notification::class); }

    public function comment() { return $this->belongsTo(Comment::class); }

}
