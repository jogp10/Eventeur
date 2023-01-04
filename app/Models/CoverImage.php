<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'name', 'created_at', 'updated_at'
   ];

    public function event() { return $this->belongsTo(Event::class); }
}
