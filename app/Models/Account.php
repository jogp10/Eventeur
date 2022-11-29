<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email', 'name', 'password', 'description', 'age', 'remember_token', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password'
    ];

    public function user() { return $this->hasOne(User::class); }
    public function admin() { return $this->hasOne(Admin::class); }
}
