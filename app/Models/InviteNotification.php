<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InviteNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'notification_id', 'invite_id', 'created_at', 'updated_at'
    ];

    public function user() { return $this->belongsTo(User::class); }
    
    public function notification() { return $this->belongsTo(Notification::class); }

    public function invite() { return $this->belongsTo(Invite::class); }
}
