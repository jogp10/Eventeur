<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'event_id', 'content', 'created_at', 'updated_at'
    ];
    public function user() { return $this->belongsTo(User::class); }

    public function event() { return $this->belongsTo(Event::class); }
}
