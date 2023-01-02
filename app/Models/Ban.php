<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'user_id', 'event_id', 'reason', 'created_at', 'updated_at', 'expired_at'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function admin() { return $this->belongsTo(Admin::class); }
}
