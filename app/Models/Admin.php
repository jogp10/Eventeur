<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'account_id', 'created_at', 'updated_at'
    ];

    public function account() { return $this->belongsTo(Account::class); }

    public function bans() { return $this->hasMany(Ban::class); }

}
