<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'user_id', 'num_of_tickets', 'price', 'created_at', 'updated_at'
   ];

    public function user() { return $this->belongsTo(User::class); }

    public function event() { return $this->belongsTo(Event::class); }
}
