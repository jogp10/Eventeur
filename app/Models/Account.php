<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email', 'name', 'password', 'description', 'age', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password'
    ];


    public function user() { return $this->hasOne(User::class); }
    public function admin() { return $this->belongsTo(Admin::class); }

}
