<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InviteNotification extends Model
{
    use HasFactory;

    public function notification() { return $this->hasOne(Notification::class); }

    public function invite() { return $this->hasOne(Invite::class); }
}
