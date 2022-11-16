<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InviteNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id', 'invite_id', 'created_at', 'updated_at'
    ];

    public function notification() { return $this->hasOne(Notification::class); }

    public function invite() { return $this->hasOne(Invite::class); }
}
