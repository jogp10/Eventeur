<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'user_id', 'ban_type', 'created_at', 'updated_at'
    ];

    public function user() { return $this->hasOne(User::class); }
    public function admin() { return $this->hasOne(Admin::class); }
}
