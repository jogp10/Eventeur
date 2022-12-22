<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'question', 'created_at', 'updated_at'
    ];

    public function event() { return $this->belongsTo(Event::class); }

    public function pollOptions() { return $this->hasMany(PollOption::class); }
}
