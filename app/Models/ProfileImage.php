<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'path', 'created_at', 'updated_at'
   ];

    public function user() { return $this->hasOne(User::class); }
}
